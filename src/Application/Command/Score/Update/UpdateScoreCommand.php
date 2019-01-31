<?php


namespace App\Application\Command\Score\Update;


class UpdateScoreCommand
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $score;

    /**
     * UpdateGameCommand constructor.
     * @param int $score
     */
    public function __construct(string $username, int $score)
    {
        $this->username = $username;
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

}