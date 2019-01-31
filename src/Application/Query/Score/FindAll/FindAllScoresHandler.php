<?php

namespace App\Application\Query\Score\FindAll;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Score\Repository\ScoreRepositoryInterface;

class FindAllScoresHandler implements QueryHandlerInterface
{
    private $repository;

    public function __construct(ScoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindAllScoresQuery $query)
    {
        return $this->repository->findAll();
    }
}