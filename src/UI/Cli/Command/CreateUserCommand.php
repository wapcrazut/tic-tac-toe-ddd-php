<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\User\Add\AddCommand as CreateUser;
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
        $command = new CreateUser(
            $username = $input->getArgument('username')
        );

        //$this->commandBus->handle($command);

        $output->writeln('<info>User Created: </info>');
        $output->writeln('');
        $output->writeln("Username: $username");
    }
}
