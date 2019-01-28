<?php


namespace App\UI\Cli\Command;

use League\Tactician\CommandBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowLeaderboardCommand extends Command
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

        $leaderboardRepository = $this->entityManager->getRepository('App\Domain\Leaderboard\Leaderboard');
        $leaderboard = $leaderboardRepository->findAll();

        try {

            if ($leaderboard == null) {
                throw new \Exception('Leaderboard is empty');
            } else {

                $output->writeln('<info>Leaderboard list: </info>');
                foreach ($leaderboard as $record) {
                    $output->writeln($record->getUsername()." : ".$record->getScore());
                }

            }

        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        // TODO: Implement command bus.
        //$this->commandBus->handle($command);
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
}