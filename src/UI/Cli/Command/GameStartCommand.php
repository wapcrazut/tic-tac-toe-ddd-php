<?php


namespace App\UI\Cli\Command;

use App\Application\Command\Game\Add\AddCommand as StartGame;
use App\Domain\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
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
            ->addOption('playerA', 'a', InputArgument::REQUIRED, 'Username of first player')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerA = $this->askUserData('first', $input, $output);
        $playerB = $this->askUserData('second', $input, $output);

        $command = new StartGame(
            $playerA = $playerA['username'],
            $playerB = $playerB['username']
        );

        //$this->commandBus->handle($command);

        $output->writeln('<info>Created new game: </info>');
        $output->writeln('');
        $output->writeln("Player A: $playerA");
        $output->writeln("Player B: $playerB");
    }

    public function askUserData($player, InputInterface $input, OutputInterface $output) {

        $helper = $this->getHelper('question');

        $question = new Question("Username of $player player: ");
        $username = $helper->ask($input, $output, $question);

        $question = new ChoiceQuestion('Please select your marker: ', ['X', 'O']);
        $question->setErrorMessage('Marker %s is invalid.');

        $marker = $helper->ask($input, $output, $question);

        $output->writeln("Player $username selected: $marker");

        $player = array(
            'username' => $username,
            'mark' => $marker
        );

        return $player;
    }

    public function askNextStep() {

    }

    public function showIntro() {

    }

    public function gameHasWinner() {

    }

    public function gameIsDraw() {

    }
}