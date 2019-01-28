<?php


namespace App\UI\Cli\Command;

use App\Application\Command\Game\Add\AddCommand as StartGame;
use App\Domain\Game\Game;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
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
        $playerA = $this->askUserData('first');
        $playerB = $this->askUserData('second');

        $gameRepository = $this->entityManager->getRepository("App\Domain\Game\Game");

        try {

            $game = new Game($playerA['username'], $playerB['username']);
            $this->entityManager->persist($game);
            $this->entityManager->flush();

            $output->writeln('<info>Created new game: </info>');
            $output->writeln("Player A: ".$playerA['username']." vs. Player B: ".$playerB['username']);

            $board = array(
                1 => '',
                2 => '',
                3 => '',
                4 => '',
                5 => '',
                6 => '',
                7 => '',
                8 => '',
                9 => ''
            );

            $continueGame = false;
            $rounds = 0;

            while ($continueGame != false) {

                foreach ($board as $move) {

                    $movement = $this->askNextStep($playerA['mark']);

                    if (empty($board[$movement]) || array_key_exists($movement, $board)) {
                        $board[$movement] = $playerA['mark'];
                    } else {
                        $output->writeln('Ups! That cell is already taken or de movement is not valid.');
                    }
                }

                $continueGame = $this->askNextRound();
                $rounds++;
            }



        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        // TODO: Implement command bus.
        //$this->commandBus->handle($command);

    }

    public function askUserData($player) {

        $helper = $this->getHelper('question');
        $question = new Question("Username of $player player: ");
        $username = $helper->ask($this->input, $this->output, $question);

        $question = new ChoiceQuestion('Please select your marker: ', ['X', 'O']);
        $question->setErrorMessage('Marker %s is invalid.');
        $marker = $helper->ask($this->input, $this->output, $question);

        $this->output->writeln("Player $username selected: $marker");
        $player = array(
            'username' => $username,
            'mark' => $marker
        );

        return $player;
    }

    public function askNextStep() {

        $helper = $this->getHelper('question');
        $question = new Question("Choose your cell number for mark: ");
        $cell = $helper->ask($this->input, $this->output, $question);

        return $cell;
    }

    public function askNextRound() {

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Want to continue another round? (y/n)', false,  '/^(y)/i');
        $response = $helper->ask($this->input, $this->output, $question);

        if (!$helper->ask($this->input, $this->output, $question)) {
            return true;
        }

        return $response;
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

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;

    private $entityManager;

    private $input;

    private $output;
}