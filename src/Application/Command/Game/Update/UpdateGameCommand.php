<?php

namespace App\Application\Command\Game\Update;

class UpdateGameCommand
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
     * UpdateGameCommand constructor.
     * @param int $rounds
     * @param string $winner
     */
    public function __construct(int $rounds, string $winner)
    {
        $this->rounds = $rounds;
        $this->winner = $winner;
    }

    /**
     * @return int
     */
    public function getRounds(): int
    {
        return $this->rounds;
    }

    /**
     * @return string
     */
    public function getWinner(): string
    {
        return $this->winner;
    }
}