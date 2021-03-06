<?php


namespace App\Application\Command\User\Add;


class AddUserCommand
{
    /**
     * @var string
     */
    public $username;

        /**
     * UpdateGameCommand constructor.
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