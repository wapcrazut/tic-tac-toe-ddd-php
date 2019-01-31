<?php


namespace App\UI\Cli\Command;

use App\Application\Query\Score\FindAll\FindAllScoresQuery;
use League\Tactician\CommandBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowScoreCommand extends Command
{
    private $queryBus;

    private $entityManager;

    public function __construct(CommandBus $queryBus, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->queryBus = $queryBus;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setName('scores:show')
            ->setDescription('Shows Score.')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $query = new FindAllScoresQuery();
        $scores = $this->queryBus->handle($query);



        try {

            if (empty($scores)) {
                throw new \Exception('There is not scores to show.');
            } else {

                $output->writeln('<info>Score list: </info>');
                foreach ($scores as $record) {
                    $output->writeln($record->getUsername()." : ".$record->getScore());
                }

            }

        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        // TODO: Implement command bus.
        //$this->commandBus->handle($command);
    }
}