<?php

namespace App\Domain\Leaderboard\Repository;


use App\Domain\Leaderboard\Leaderboard;

interface LeaderboardRepositoryInterface
{
    public function add(Leaderboard $leaderboard);
    public function findAll();
}