<?php


namespace App\Application\Query\User\FindAll;

use App\Domain\User\Repository\UserRepositoryInterface;

class FindAllUsersQuery
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}