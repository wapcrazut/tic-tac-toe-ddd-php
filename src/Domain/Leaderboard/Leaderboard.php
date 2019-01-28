<?php

namespace App\Domain\Leaderboard;

Use Doctrine\ORM\Mapping as ORM;

/**
 * Class Leaderboard
 * @ORM\Entity(repositoryClass="App\Domain\Leaderboard\Repository\LeaderboardRepository")
 * @ORM\Table(name="leaderboard")
 */
class Leaderboard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="username", type="string")
     */
    private $username;

    /**
     * @var int
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * Leaderboard constructor.
     * @param string $username
     * @param int $score
     */
    public function __construct(string $username, int $score)
    {
        $this->username = $username;
        $this->score = $score;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

}