<?php


namespace App\UI\Cli\Command;

use App\Application\Command\Game\Start\UpdateCommand as StartGame;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LeaderboardShowCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('leaderboard:show')
            ->setDescription('Shows leaderboard.')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new StartGame(
            $playerA = $input->getArgument('playerA'),
            $playerB = $input->getArgument('playerB')
        );

        //$this->commandBus->handle($command);

        $output->writeln('<info>Created new game: </info>');
        $output->writeln('');
        $output->writeln("Player A: $playerA");
        $output->writeln("Player B: $playerB");
    }
}