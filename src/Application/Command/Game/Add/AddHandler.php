<?php


namespace App\Application\Command\Game\Add;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\Game\Repository\GameRepositoryInterface;

class AddHandler implements CommandHandlerInterface
{
    /**
     * @param AddCommand $command
     */
    public function __invoke(AddCommand $command): void
    {
        // TODO: Implement method.
    }

    /**
     * AddHandler constructor.
     * @param GameRepositoryInterface $gameRepository
     */
    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /** @var GameRepositoryInterface */
    private $gameRepository;
}