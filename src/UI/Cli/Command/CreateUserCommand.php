<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\User\Add\AddCommand as CreateUser;
use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('user:create')
            ->setDescription('Given a username, generates a new user.')
            ->addArgument('username', InputArgument::REQUIRED, 'User username')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $username = $input->getArgument('username');
        $userRepository = $this->entityManager->getRepository("App\Domain\User\User");
        $user = $userRepository->findOneBy(['username' => $username]);

        try {

            if ($user != null) {
                throw new \Exception('User already exists');
            } else {
                $user = new User($input->getArgument('username'));
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $output->writeln('<info>User Created: </info>');
                $output->writeln("Username: $username");
            }

        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        // TODO: Implement command bus.
        //$this->commandBus->handle($command);

    }


    /**
     * CreateUserCommand constructor.
     * @param CommandBus $commandBus
     * @param EntityManager $entityManager
     */
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

    /**
     * @var EntityManager
     */
    private $entityManager;
}
