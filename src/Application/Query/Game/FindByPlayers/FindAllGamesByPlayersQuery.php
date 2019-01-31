<?php


namespace App\Application\Query\Game\FindByPlayers;


class FindAllGamesByPlayersQuery
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
     * FindAllGamesByPlayersQuery constructor.
     * @param string $playerA
     * @param string $playerB
     */
    public function __construct(string $playerA, string $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerA;
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