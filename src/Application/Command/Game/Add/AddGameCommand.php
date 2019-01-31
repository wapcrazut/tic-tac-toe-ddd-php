<?php


namespace App\Application\Command\Game\Add;


class AddGameCommand
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
     * AddGameCommand constructor.
     * @param string $playerA
     * @param string $playerB
     */
    public function __construct(string $playerA, string $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
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
}