<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\User\Add\AddUserCommand;
use App\Application\Query\User\FindByUsername\FindUsersByUsernameQuery;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var CommandBus
     */
    private $queryBus;

    /**
     * CreateUserCommand constructor.
     * @param CommandBus $commandBus
     * @param CommandBus $queryBus
     */
    public function __construct(CommandBus $commandBus, CommandBus $queryBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     *
     */
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

        $query = new FindUsersByUsernameQuery($username);
        $user = $this->queryBus->handle($query);

        try {

            if (!empty($user)) {
                throw new \Exception('User already exists');
            } else {
                $command = new AddUserCommand($username);
                $this->commandBus->handle($command);

                $output->writeln('<info>User Created: </info>');
                $output->writeln("Username: $username");
            }

        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }

    }
}
