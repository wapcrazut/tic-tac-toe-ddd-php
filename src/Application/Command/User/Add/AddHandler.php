<?php


namespace App\Application\Command\User\Add;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class AddHandler implements CommandHandlerInterface
{
    public function __invoke(AddCommand $command): void
    {
        $user = $this->userRepository->get($command->userUuid);

        $user->changeEmail($command->email);

        $this->userRepository->store($user);
    }

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** @var UserRepositoryInterface */
    private $userRepository;
}