<?php


namespace App\Application\Command\Game\Add;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\Game\Repository\GameRepositoryInterface;

class AddHandler implements CommandHandlerInterface
{
    public function __invoke(UpdateCommand $command): void
    {
        $game = $this->gameRepository->get($command->playerA);


        $game->changeEmail($command->email);

        $this->userRepository->store($game);
    }

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /** @var GameRepositoryInterface */
    private $gameRepository;
}