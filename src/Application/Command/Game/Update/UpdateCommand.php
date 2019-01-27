<?php

namespace App\Application\Command\Game\Update;

class UpdateCommand
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