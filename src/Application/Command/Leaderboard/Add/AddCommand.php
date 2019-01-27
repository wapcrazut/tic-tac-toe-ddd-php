<?php

namespace App\Application\Command\Leaderboard\Add;

class AddCommand
{
    public $username;
    public $score;

    public function __construct(string $username, int $score)
    {
        $this->username = $username;
        $this->score = $score;
    }
}