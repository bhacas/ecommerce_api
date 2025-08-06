<?php

namespace App\User\Interface\Http\Controller;

use App\User\Application\Query\GetLoggedUserQuery;
use App\User\Application\Query\GetUserTokenQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly TokenStorageInterface $tokenStorage,
    ) {
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(#[MapRequestPayload] GetUserTokenQuery $query): JsonResponse
    {
        $envelope = $this->queryBus->dispatch($query);
        $authTokenDto = $envelope->last(HandledStamp::class)->getResult();

        return new JsonResponse($authTokenDto);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/logged', name: 'api_logged', methods: ['GET'])]
    public function logged(): JsonResponse
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!$user || !\is_object($user)) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        $envelope = $this->queryBus->dispatch(new GetLoggedUserQuery($user->getUserIdentifier()));
        $userDto = $envelope->last(HandledStamp::class)->getResult();

        return new JsonResponse($userDto);
    }
}
