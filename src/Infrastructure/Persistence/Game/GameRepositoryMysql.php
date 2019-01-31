<?php


namespace App\Infrastructure\Persistence\Game;


use App\Domain\Game\Game;
use App\Domain\Game\Repository\GameRepositoryInterface;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class GameRepositoryMysql implements GameRepositoryInterface
{
    private $connection;

    public function __construct(EntityManagerInterface $connection)
    {
        $this->connection = $connection->getConnection();

    }

    public function add(Game $game)
    {
        $playerA = $game->getPlayerA();
        $playerB = $game->getPlayerB();
        try {
            return $this->connection->executeQuery("INSERT INTO game (player_a, player_b) VALUES ('$playerA','$playerB')");
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

    public function update(Game $game)
    {
        $rounds = $game->getRounds();
        $winner = $game->getWinner();
        try {
            return $this->connection->executeQuery("UPDATE game SET (score, winner) VALUES ('$rounds','$winner') WHERE player_a = '' AND player_b = ''");
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function findAll()
    {
        try {
            return $this->connection->executeQuery("SELECT * FROM game")->fetchAll();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}