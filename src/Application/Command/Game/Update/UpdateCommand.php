<?php

namespace App\Application\Command\Game\Update;

class UpdateCommand
{
    /**
     * @var int
     */
    public $rounds;

    /**
     * @var string
     */
    public $winner;

    /**
     * UpdateCommand constructor.
     * @param int $rounds
     * @param string $winner
     */
    public function __construct(int $rounds, string $winner)
    {
        $this->rounds = $rounds;
        $this->winner = $winner;
    }
}