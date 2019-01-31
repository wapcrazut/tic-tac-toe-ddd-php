<?php


namespace App\Application\Command\User\Add;


use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use App\Application\Command\CommandHandlerInterface;

class AddUserHandler implements CommandHandlerInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddUserCommand $command): void
    {
        $this->repository->add(new User($command->getUsername()));
    }
}