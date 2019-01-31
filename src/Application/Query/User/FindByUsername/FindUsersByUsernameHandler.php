<?php


namespace App\Application\Query\User\FindByUsername;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class FindUsersByUsernameHandler implements QueryHandlerInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        return $this->repository = $repository;
    }

    public function __invoke(FindUsersByUsernameQuery $query)
    {
        return $this->repository->findByUsername($query->getUsername());
    }
}