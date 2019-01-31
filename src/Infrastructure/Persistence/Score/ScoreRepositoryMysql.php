<?php


namespace App\Infrastructure\Persistence\Score;


use App\Domain\Score\Score;
use App\Domain\Score\Repository\ScoreRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ScoreRepositoryMysql implements ScoreRepositoryInterface
{
    private $connection;

    public function __construct(EntityManagerInterface $connection)
    {
        $this->connection = $connection->getConnection();

    }

    public function add(Score $score)
    {
        $username = $score->getUsername();
        $score = $score->getScore();
        try {
            return $this->connection->executeQuery("INSERT INTO score (username, score) VALUES ('$username', $score)");
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

    public function update(Score $score)
    {
        $username = $score->getUsername();
        $score = $score->getScore();
        try {
            return $this->connection->executeQuery("UPDATE score SET score = $score WHERE username = '$username'");
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function findAll()
    {
        try {
            return $this->connection->executeQuery("SELECT * FROM score")->fetchAll();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}