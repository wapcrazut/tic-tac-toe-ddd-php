<?php


namespace App\Application\Query\User\FindByUsername;


class FindUsersByUsernameQuery
{
    /**
     * @var string
     */
    private $username;

    /**
     * FindUsersByUsernameQuery constructor.
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