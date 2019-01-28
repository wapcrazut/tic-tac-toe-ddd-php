<?php


namespace App\Application\Command\Game\Update;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\Game\Repository\GameRepositoryInterface;

class UpdateHandler implements CommandHandlerInterface
{
    /**
     * @param UpdateCommand $command
     */
    public function __invoke(UpdateCommand $command): void
    {
        // TODO: Implement method.
    }

    /**
     * UpdateHandler constructor.
     * @param GameRepositoryInterface $gameRepository
     */
    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /** @var GameRepositoryInterface */
    private $gameRepository;
}