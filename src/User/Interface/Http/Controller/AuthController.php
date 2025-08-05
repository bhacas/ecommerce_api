<?php

namespace App\User\Interface\Http\Controller;

use App\Shared\Application\Bus\CommandBus;
use App\Shared\Application\Bus\QueryBus;
use App\User\Application\Command\LoginUserCommand;
use App\User\Application\Query\GetLoggedUserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly CommandBus            $commandBus,
        private readonly QueryBus              $queryBus,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly ValidatorInterface     $validator
    )
    {
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $command = new LoginUserCommand(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        $errors = $this->validator->validate($command);

        if (count($errors) > 0) {
            return new JsonResponse([
                'errors' => array_map(fn($e) => $e->getPropertyPath() . ': ' . $e->getMessage(), iterator_to_array($errors))
            ], 400);
        }

        $token = $this->commandBus->handle($command);

        return new JsonResponse(['token' => $token]);
    }

    #[Route('/api/logged', name: 'api_logged', methods: ['GET'])]
    public function logged(): JsonResponse
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!$user || !\is_object($user)) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        $dto = $this->queryBus->handle(new GetLoggedUserQuery($user->getUserIdentifier()));

        return $this->json($dto);
    }
}
