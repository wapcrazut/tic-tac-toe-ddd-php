<?php


namespace App\Application\Command\Score\Add;


class AddScoreCommand
{

    /**
     * @var string
     */
    private $username;

    /**
     * @var integer
     */
    private $score;

    /**
     * AddScoreCommand constructor.
     * @param string $username
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