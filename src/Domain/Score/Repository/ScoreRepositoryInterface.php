<?php


namespace App\Domain\Score\Repository;


use App\Domain\Score\Score;

interface ScoreRepositoryInterface
{
    /**
     * @param Score $Score
     * @return mixed
     */
    public function add(Score $Score);

    /**
     * @param Score $Score
     * @return mixed
     */
    public function update(Score $Score);

    /**
     * @return mixed
     */
    public function findAll();
}