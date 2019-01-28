<?php


namespace App\Application\Command\User\Add;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class AddHandler implements CommandHandlerInterface
{
    /**
     * @param AddCommand $command
     */
    public function __invoke(AddCommand $command): void
    {
        // TODO: Implement method.
    }

    /**
     * AddHandler constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** @var UserRepositoryInterface */
    private $userRepository;
}