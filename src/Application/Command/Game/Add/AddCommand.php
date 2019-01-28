<?php


namespace App\Application\Command\Game\Add;


class AddCommand
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
     * AddCommand constructor.
     * @param string $playerA
     * @param string $playerB
     */
    public function __construct(string $playerA, string $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
    }
}