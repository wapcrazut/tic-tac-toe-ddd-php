<?php


namespace App\Domain\User\Repository;


use App\Domain\User\User;

interface UserRepositoryInterface
{

    /**
     * @param User $user
     * @return mixed
     */
    public function add(User $user);

    /**
     * @param string $username
     * @return mixed
     */
    public function delete(string $username);

    /**
     * @param string $username
     * @return mixed
     */
    public function findByUsername(string $username);

    /**
     * @return mixed
     */
    public function findAll();
}
