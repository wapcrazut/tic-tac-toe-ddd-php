<?php


namespace App\Application\Command\Score\Add;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\Score\Score;
use App\Domain\Score\Repository\ScoreRepositoryInterface;

class AddScoreHandler implements CommandHandlerInterface
{
    private $repository;

    public function __construct($repository = null)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddScoreCommand $command): void
    {
        $this->repository->add(new Score($command->getUsername(), $command->getScore()));
    }
}