<?php


namespace App\UI\Cli\Command;

use App\Application\Command\Game\Add\AddGameCommand;
use App\Application\Command\Game\Update\UpdateGameCommand;
use App\Application\Command\Score\Add\AddScoreCommand;
use App\Application\Command\User\Add\AddUserCommand;
use App\Application\Query\Score\FindAll\FindAllScoresQuery;
use App\Application\Query\User\FindByUsername\FindUsersByUsernameQuery;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class GameStartCommand extends Command
{

    /**
     * @var CommandBus
     */
    private $commandBus;

    private $queryBus;

    private $input;

    private $output;

    private $players;

    private $playerTurn = 0;

    private $moves = 0;

    private $restart = true;

    private $board = array();

    private $rounds = 1;

    const EMPTY_CELL = " ";

    const VALID_COMBINATIONS = array(
        array(1, 2, 3),
        array(4, 5, 6),
        array(7, 8, 9),
        array(1, 4, 7),
        array(2, 5, 8),
        array(3, 6, 9),
        array(1, 5, 9),
        array(3, 5, 7)
    );

    const BOARD_MAPPING = array(
        1 => array(0,0),
        2 => array(1,0),
        3 => array(2,0),
        4 => array(0,1),
        5 => array(1,1),
        6 => array(2,1),
        7 => array(0,2),
        8 => array(1,2),
        9 => array(2,2)
    );

    public function __construct(CommandBus $commandBus, CommandBus $queryBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->players = array();
    }



    protected function configure(): void
    {
        $this
            ->setName('game:start')
            ->setDescription('Starts a new game.')
            ->addArgument('playerA', InputArgument::OPTIONAL, 'Username of first player')
            ->addArgument('playerB', InputArgument::OPTIONAL, 'Username of second player')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->input = $input;
        $this->output = $output;

        $this->showIntro();
        $this->askUserData('first');
        $this->askUserData('second');

        try {

            $command = new AddGameCommand($this->players[0]['username'], $this->players[1]['username']);
            $this->commandBus->handle($command);

            $output->writeln('<info>Created new game: </info>');
            $output->writeln("Player ".$this->players[0]['username']." vs. Player ".$this->players[1]['username']);

            while ($this->restart == true) {

                $this->playerTurn = 0;
                $this->moves = 0;
                $this->buildBoard();

                while (($winner = $this->checkGameWinner()) == null) {

                    try {
                        $this->askNextStep();
                        $this->showBoard();

                        if ($this->checkGameDraw()) {
                            $this->drawDetected();
                            break;
                        }

                    } catch (\Exception $exception) {
                        $this->output->writeln($exception->getMessage());
                        continue;
                    }
                }

                if (!empty($winner)) {
                    $player = $this->detectPlayerByMark($winner);
                    $player['score']++;
                    $this->winnerDetected($player['username']);
                }

                $this->rounds++;
                $this->restart = $this->askNextRound();
            }

            $winnerPlayer = $this->detectPlayerByMark($winner);

            $command = new UpdateGameCommand($this->players[0]['username'], $this->players[1]['username'], $this->rounds, $winnerPlayer['username']);
            $this->commandBus->handle($command);

            $command = new AddScoreCommand($winnerPlayer['username'], $winnerPlayer['score']);
            $this->commandBus->handle($command);

            $this->showResult($winnerPlayer['username']);

        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

    }

    public function buildBoard() {
        for ($y = 0; $y < 3; $y++) {
            for ($x = 0; $x < 3; $x++) {
                $this->board[$x][$y] = self::EMPTY_CELL;
            }
        }
    }

    public function askUserData($player)
    {
        $helper = $this->getHelper('question');
        $question = new Question("Username of $player player: ");
        $username = $helper->ask($this->input, $this->output, $question);

        $this->checkAndCreateUser($username);

        while (count($this->players) < 2) {

            $question = new ChoiceQuestion('Please select your marker: ', ['X', 'O']);
            $question->setErrorMessage('Marker %s is invalid.');
            $marker = $helper->ask($this->input, $this->output, $question);

            try {
                $this->checkMarkers($marker);
                $this->output->writeln("Player $username selected: $marker");
                $this->players[] = array(
                    'username' => $username,
                    'marker' => $marker,
                    'score' => 0,
                );
                return $player;
            } catch (\Exception $exception) {
                $this->output->writeln($exception->getMessage());
                continue;
            }
        }

    }

    public function checkMarkers($marker)
    {
        foreach ($this->players as $player) {
            if ($player['marker'] == $marker) {
                throw new \Exception('That option is already taken.');
            }
        }

        return false;
    }

    public function checkAndCreateUser($username)
    {
        $query = new FindUsersByUsernameQuery($username);
        $user = $this->queryBus->handle($query);

        try {

            if (empty($user)) {
                $command = new AddUserCommand($username);
                $this->commandBus->handle($command);
                $this->output->writeln("<info>User created: $username</info>");
            } else {
                $this->output->writeln("<info>Loged in as: $username</info>");
            }

        } catch (\Exception $exception) {
            $this->output->writeln($exception->getMessage());
        }
    }

    public function askNextStep()
    {
        $this->playerTurn = $this->moves % count($this->players);
        $player = $this->players[$this->playerTurn];

        $helper = $this->getHelper('question');
        $question = new Question($player['username'].", choose your cell number for mark: ");
        $movement = $helper->ask($this->input, $this->output, $question);

        if ($this->validateMovement($movement)) {
            $cell = self::BOARD_MAPPING[$movement];
            $this->board[$cell[0]][$cell[1]] = $player['marker'];
            $this->moves++;
        } else {
            throw new \Exception('Ups! That cell is already taken or the movement is not valid.');
        }

        return $movement;
    }

    public function validateMovement($movement)
    {

        if ($movement < 1 || $movement > 9) {
            return false;
        }

        $cell = self::BOARD_MAPPING[$movement];
        if ($this->board[$cell[0]][$cell[1]] != self::EMPTY_CELL) {
            return false;
        }

        return true;
    }

    public function askNextRound()
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Want to continue another round? (y/n): ', false,  '/^(y)/i');
        $response = $helper->ask($this->input, $this->output, $question);

        return $response;
    }

    public function showBoard()
    {
        $section = $this->output->section();
        $section->writeln("
             ________________________________________________________________
            |________________________________________________________________|
            |                         Choose wisely...                       |
            |                                                                |
            |                           ".$this->board[0][0]." | ".$this->board[1][0]." | ".$this->board[2][0]."                            |
            |                          ---|---|---                           |
            |                           ".$this->board[0][1]." | ".$this->board[1][1]." | ".$this->board[2][1]."                            |
            |                          ---|---|---                           |
            |                           ".$this->board[0][2]." | ".$this->board[1][2]." | ".$this->board[2][2]."                            |
            |                                                                |
            | Type the number of your next move.                             |
            |________________________________________________________________|
        ");
    }

    public function showIntro()
    {
        $this->output->writeln("
             ________________________________________________________________
            |________________________________________________________________|
            |                    ¡Welcome to Tic-Tac-Toe!                    |
            |                                                                |
            |                   Two players tic-tac-toe game.                |
            |                                                                |
            |                           1 | 2 | 3                            |
            |                          ---|---|---                           |
            |                           4 | 5 | 6                            |
            |                          ---|---|---                           |
            |                           7 | 8 | 9                            |
            |                                                                |
            | To start playing you need to enter player username.            |
            | Then choose your marker.                                       |
            |                                                                |
            |________________________________________________________________|
        ");
    }

    public function showResult($winner)
    {
        $this->output->writeln("<info>The final winner is $winner</info>");
    }

    public function winnerDetected($winner)
    {
        $this->output->writeln("<info>Round winner is $winner</info>");
    }

    public function drawDetected()
    {
        $this->output->writeln("<info>No one wins! >:)</info>");
    }

    public function checkGameDraw()
    {
        return ((9 == $this->moves) && ($this->checkGameWinner() == null));
    }

    public function checkGameWinner()
    {

        foreach (self::VALID_COMBINATIONS as $combination)
        {
            $winner = '';
            foreach ($combination as $cell)
            {
                $cell = self::BOARD_MAPPING[$cell];
                if (isset($this->board[$cell[0]][$cell[1]])) {
                    $winner .= trim($this->board[$cell[0]][$cell[1]]) . ",";
                }

            }

            $winner = trim($winner, ",");
            $winner = explode(",", $winner);
            if (count($winner) < 3) {
                continue;
            }
            if ($winner[0] === $winner[1]
                && $winner[1] === $winner[2]
                && $winner[2] === $winner[0]
            ) {
                return $winner[0];
            }
        }

        return null;

    }

    public function detectPlayerByMark($mark)
    {
        foreach ($this->players as $player)
        {
            if ($player['marker'] == $mark) {
                return $player;
            }
        }
    }

}