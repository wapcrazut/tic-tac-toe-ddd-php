<?php


namespace App\Application\Command\User\Delete;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class DeleteHandler implements CommandHandlerInterface
{
    public function __invoke(DeleteCommand $command): void
    {
        // TODO: Implement method.
    }

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** @var UserRepositoryInterface */
    private $userRepository;
}