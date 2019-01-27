<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\User;

use App\Application\Query\User\FindByUsername\FindByUsernameQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetUserByEmailController
{
    /**
     * @Route(
     *     "/user/{username}",
     *     name="find_user",
     *     methods={"GET"}
     * )
     *
     * @throws \Exception
     */
    public function __invoke(string $username): JsonResponse
    {
        if ($username == null) {
            throw new \Exception('Username can\'t be null');
        }

        $command = new FindByUsernameQuery($username);

        // TODO: runs command

        return $this->json($user);
    }
}
