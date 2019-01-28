<?php


namespace App\Infrastructure\User\Repository;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;

class UserStore implements UserRepositoryInterface
{
    public function add(User $user)
    {
        // TODO: Implement add() method.
    }

    public function delete(string $username)
    {
        // TODO: Implement delete() method.
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findByUsername(string $username)
    {
        // TODO: Implement findByUsername() method.
    }
}