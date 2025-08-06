<?php

namespace App\User\Application\Query;

use App\User\Application\Dto\AuthTokenDto;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\Security\SymfonyUserAdapter;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

#[AsMessageHandler]
readonly class GetUserTokenQueryHandler
{
    public function __construct(
        private UserRepositoryInterface     $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface    $jwtManager
    )
    {
    }

    public function __invoke(GetUserTokenQuery $query): AuthTokenDto
    {
        $user = new SymfonyUserAdapter($this->userRepository->findByEmail($query->email));

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $query->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return new AuthTokenDto($this->jwtManager->create($user));
    }
}
