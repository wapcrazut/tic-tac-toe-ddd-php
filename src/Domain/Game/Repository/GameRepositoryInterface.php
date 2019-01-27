<?php

namespace App\Domain\Game\Repository;


use App\Domain\Game\Game;

interface GameRepositoryInterface
{

    /**
     * @param Game $game
     * @return mixed
     */
    public function add(Game $game);

    /**
     * @param Game $game
     * @return mixed
     */
    public function update(Game $game);

    /**
     * @return mixed
     */
    public function findAll();
}