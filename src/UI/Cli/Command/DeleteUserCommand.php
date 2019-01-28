<?php


namespace App\UI\Cli\Command;

use App\Application\Command\User\Delete\DeleteCommand as DeleteUser;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUserCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('user:delete')
            ->setDescription('Deletes the given user by username if exists.')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $username = $input->getArgument('username');
        $userRepository = $this->entityManager->getRepository('App\Domain\User\User');
        $user = $userRepository->findOneBy(['username' => $username]);

        try {

            if ($user == null) {
                throw new \Exception('User doesn\'t exists');
            } else {

                $this->entityManager->remove($user);
                $this->entityManager->flush();

                $output->writeln('<info>User deleted: </info>');
                $output->writeln("Username: $username");
            }

        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        // TODO: Implement command bus.
        //$this->commandBus->handle($command);

    }

    /**
     * DeleteUserCommand constructor.
     * @param CommandBus $commandBus
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Connection
     */
    private $connection;
}