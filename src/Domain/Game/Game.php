<?php

namespace App\Domain\Game;


class Game
{
    /**
     * @var string
     */
    private $playerA;

    /**
     * @var string
     */
    private $playerB;

    /**
     * @var int
     */
    private $rounds;

    /**
     * @var string
     */
    private $winner;

    /**
     * Game constructor.
     * @param string $playerA
     * @param string $platerB
     * @param int $rounds
     * @param string $winner
     */
    public function __construct(string $playerA, string $platerB, int $rounds, string $winner)
    {
        $this->playerA = $playerA;
        $this->playerB = $this->playerA;
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