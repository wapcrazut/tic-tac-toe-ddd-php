<?php


namespace App\Domain\Leaderboard\Repository;


use App\Domain\Leaderboard\Leaderboard;

interface LeaderboardRepositoryInterface
{
    /**
     * @param Leaderboard $leaderboard
     * @return mixed
     */
    public function add(Leaderboard $leaderboard);

    /**
     * @return mixed
     */
    public function findAll();
}