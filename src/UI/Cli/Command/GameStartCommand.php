<?php


namespace App\UI\Cli\Command;

use App\Application\Command\Game\Add\AddGameCommand;
use App\Application\Command\Game\Update\UpdateGameCommand;
use App\Application\Command\User\Add\AddUserCommand;
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

    private $board;

    private $players;

    private $moves = 0;

    private $playerTurn = 0;

    private $continueGame = true;

    private $rounds = 0;

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
            $output->writeln("Player A: ".$this->players[0]['username']." vs. Player B: ".$this->players[1]['username']);

            $this->board = array();

            $this->showBoard($this->board);

            while ($this->checkGameWinner() == null) {

                try {
                    $this->askNextStep();
                    //$this->showBoard($this->board);
                    var_dump($this->board);
                } catch (\Exception $exception) {
                    $this->output->writeln($exception->getMessage());
                    continue;
                }

                //$this->rounds++;
            }


            $command = new UpdateGameCommand($this->rounds, '');
            $this->commandBus->handle($command);

        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

    }

    public function askUserData($player) {

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
                    'marker' => $marker
                );
                return $player;
            } catch (\Exception $exception) {
                $this->output->writeln($exception->getMessage());
                continue;
            }
        }

    }

    public function checkMarkers($marker) {

        foreach ($this->players as $player) {
            if ($player['marker'] == $marker) {
                throw new \Exception('That option is already taken.');
            }
        }

        return false;
    }

    public function checkAndCreateUser($username) {

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

    public function askNextStep() {

        $this->playerTurn = $this->moves % count($this->players);
        $player = $this->players[$this->playerTurn];


        $helper = $this->getHelper('question');
        $question = new Question($player['username'].", choose your cell number for mark: ");
        $cell = $helper->ask($this->input, $this->output, $question);

        if ($cell >= 0 && $cell <= 9) {
            
        } else {
            throw new \Exception('Ups! That cell is already taken or de movement is not valid.');
        }

        if (empty($this->board[$cell])) {
            $this->board[$cell] = array('mark' => $player['mark']);
            $this->moves++;
        } else {
            throw new \Exception('Ups! That cell is already taken or de movement is not valid.');
        }


        return $cell;
    }

    public function askNextRound() {

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Want to continue another round? (y/n)', false,  '/^(y)/i');
        $response = $helper->ask($this->input, $this->output, $question);

        return $response;
    }

    public function showBoard() {
        $section = $this->output->section();
        $section->writeln("
             ________________________________________________________________
            |________________________________________________________________|
            |                         Choose wisely...                       |
            |                                                                |
            |                           $this->board[0] | $this->board[1] | $this->board[2]                            |
            |                          ---|---|---                           |
            |                           $this->board[3] | $this->board[4] | $this->board[5]                            |
            |                          ---|---|---                           |
            |                           $this->board[6] | $this->board[7] | $this->board[8]                            |
            |                                                                |
            | Type the number of your next move.                             |
            |________________________________________________________________|
        ");
    }

    public function showIntro() {
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

    public function showResult() {
        // TODO: Pending to implement.
    }

    public function gameHasWinner() {
        // TODO: Pending to implement.
    }

    public function gameIsDraw() {
        // TODO: Pending to implement.
    }

    public function checkGameWinner() {
        $this->board;
    }

}