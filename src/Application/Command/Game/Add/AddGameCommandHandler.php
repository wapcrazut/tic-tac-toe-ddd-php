<?php


namespace App\Application\Command\Game\Add;


use App\Domain\Game\Game;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Game\Repository\GameRepositoryInterface;

class AddGameCommandHandler implements CommandHandlerInterface
{
    private $repository;

    public function __construct(GameRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddGameCommand $command): void
    {
        $this->repository->add(new Game($command->getPlayerA(), $command->getPlayerB()));
    }
}