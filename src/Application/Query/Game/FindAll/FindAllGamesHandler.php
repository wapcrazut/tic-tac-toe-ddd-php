<?php

namespace App\Application\Query\Game\FindAll;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Game\Repository\GameRepositoryInterface;

class FindAllGamesHandler implements QueryHandlerInterface
{
    private $repository;

    public function __construct(GameRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindAllGamesQuery $query)
    {
        return $this->repository->findAll();
    }
}