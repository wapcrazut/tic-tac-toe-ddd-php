<?php

namespace App\Application\Command\Game\Update;

class UpdateGameCommand
{
    /**
     * @var string
     */
    public $playerA;

    /**
     * @var string
     */
    public $playerB;

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
     * @param string $playerA
     * @param string $playerB
     * @param int $rounds
     * @param string $winner
     */
    public function __construct(string $playerA, string $playerB, int $rounds, string $winner)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
        $this->rounds = $rounds;
        $this->winner = $winner;
    }

    /**
     * @return string
     */
    public function getPlayerA(): string
    {
        return $this->playerA;
    }

    /**
     * @return string
     */
    public function getPlayerB(): string
    {
        return $this->playerB;
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