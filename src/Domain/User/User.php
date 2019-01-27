<?php

namespace App\Domain\User;


class User
{
    /**
     * @var string
     */
    private $username;

    /**
     * User constructor.
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

}