<?php


namespace App\Application\Command\User\Delete;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use App\Application\Command\CommandHandlerInterface;

class DeleteUserHandler implements CommandHandlerInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->repository->delete(new User($command->getUsername()));
    }
}