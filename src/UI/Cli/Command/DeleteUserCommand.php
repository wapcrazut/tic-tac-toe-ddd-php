<?php


namespace App\UI\Cli\Command;

use App\Application\Command\User\Delete\DeleteCommand as DeleteUser;
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
        $command = new DeleteUser(
            $username = $input->getArgument('username')
        );

        //$this->commandBus->handle($command);

        $output->writeln('<info>User deleted: </info>');
        $output->writeln('');
        $output->writeln("Username: $username");
    }
}