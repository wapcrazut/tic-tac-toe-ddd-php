<?php


namespace App\Application\Query\User\FindAll;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class FindAllUsersHandler implements QueryHandlerInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindAllUsersQuery $query)
    {
       return $this->repository->findAll();
    }
}