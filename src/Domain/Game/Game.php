<?php

namespace App\Domain\Game;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Game
 * @ORM\Entity(repositoryClass="App\Domain\Game\Repository\GameRepository")
 * @ORM\Table(name="game")
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="player_a", type="string")
     */
    private $playerA;

    /**
     * @var string
     * @ORM\Column(name="player_b", type="string")
     */
    private $playerB;

    /**
     * @var int
     * @ORM\Column(name="rounds", type="integer", nullable=true)
     */
    private $rounds;

    /**
     * @var string
     * @ORM\Column(name="winner", type="string", nullable=true)
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