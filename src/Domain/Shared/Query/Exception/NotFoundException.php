<?php


namespace App\Domain\Shared\Query\Exception;


class NotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Not found');
    }
}