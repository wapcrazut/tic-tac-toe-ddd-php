<?php


namespace App\Application\Query\Game\FindByPlayers;


use App\Application\Query\QueryHandlerInterface;
use App\Domain\Game\Repository\GameRepositoryInterface;

class FindAllGamesByPlayersHandler implements QueryHandlerInterface
{
    private $repository;

    public function __construct(GameRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindAllGamesByPlayersQuery $query)
    {
        return $this->repository->findAll();
    }
}