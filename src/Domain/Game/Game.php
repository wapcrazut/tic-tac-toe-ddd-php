<?php

namespace App\Domain\Game;

class Game
{
    /**
     * @var
     */
    private $id;

    /**
     * @var string
     */
    private $playerA;

    /**
     * @var string
     */
    private $playerB;

    /**
     * @var
     */
    private $rounds;

    /**
     * @var
     */
    private $winner;

    /**
     * Game constructor.
     * @param string $playerA
     * @param string $playerB
     * @param int $rounds
     * @param string $winner
     */
    public function __construct(string $playerA, string $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $this->playerA;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPlayerA(): string
    {
        return $this->playerA;
    }

    /**
     * @param string $playerA
     */
    public function setPlayerA(string $playerA): void
    {
        $this->playerA = $playerA;
    }

    /**
     * @return string
     */
    public function getPlayerB(): string
    {
        return $this->playerB;
    }

    /**
     * @param string $playerB
     */
    public function setPlayerB(string $playerB): void
    {
        $this->playerB = $playerB;
    }

    /**
     * @return int
     */
    public function getRounds(): int
    {
        return $this->rounds;
    }

    /**
     * @param int $rounds
     */
    public function setRounds(int $rounds): void
    {
        $this->rounds = $rounds;
    }

    /**
     * @return string
     */
    public function getWinner(): string
    {
        return $this->winner;
    }

    /**
     * @param string $winner
     */
    public function setWinner(string $winner): void
    {
        $this->winner = $winner;
    }



}