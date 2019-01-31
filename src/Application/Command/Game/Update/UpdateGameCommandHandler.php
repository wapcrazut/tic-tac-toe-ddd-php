<?php


namespace App\Application\Command\Game\Update;


use App\Domain\Game\Game;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Game\Repository\GameRepositoryInterface;

class UpdateGameCommandHandler implements CommandHandlerInterface
{
    private $repository;

    public function __construct(GameRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateGameCommand $command): void
    {
        $this->repository->update(new Game($command->getRounds(), $command->getWinner()));
    }
}