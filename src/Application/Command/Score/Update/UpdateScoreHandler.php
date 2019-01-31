<?php


namespace App\Application\Command\Score\Update;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\Score\Score;
use App\Domain\Score\Repository\ScoreRepositoryInterface;

class UpdateScoreHandler implements CommandHandlerInterface
{
    private $repository;

    public function __construct(ScoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateScoreCommand $command): void
    {
        $this->repository->update(new Score($command->getUsername(), $command->getScore()));
    }
}