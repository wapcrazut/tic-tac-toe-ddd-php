<?php

namespace App\Application\Command\Game\Add;

class AddCommand
{
    public $playerA;

    public $playerB;

    public $rounds;

    public $winner;

    public function __construct(string $playerA, string $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
    }
}