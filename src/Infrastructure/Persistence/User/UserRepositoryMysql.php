<?php


namespace App\Infrastructure\Persistence\User;


use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;


class UserRepositoryMysql implements UserRepositoryInterface
{

    private $connection;

    public function __construct(EntityManagerInterface $connection)
    {
        $this->connection = $connection->getConnection();
    }

    public function add(User $user)
    {
        $username = $user->getUsername();
        try {
            return $this->connection->executeQuery("INSERT INTO user (username) VALUES ('$username')");
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function delete(User $user)
    {
        $username = $user->getUsername();
        try {
            return $this->connection->executeQuery("DELETE FROM user WHERE username = '$username'");
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function findAll()
    {
        try {
            return $this->connection->executeQuery("SELECT * FROM user")->fetchAll();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function findByUsername(string $username)
    {
        try {
            return $this->connection->executeQuery("SELECT * FROM user WHERE username = '$username'")->fetchAll();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}