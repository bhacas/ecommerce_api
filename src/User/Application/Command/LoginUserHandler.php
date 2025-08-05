<?php

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

readonly class LoginUserHandler
{
    public function __construct(
        private UserRepository              $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface    $jwtManager
    )
    {
    }

    public function __invoke(LoginUserCommand $command): string
    {
        $user = $this->userRepository->findByEmail($command->email);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $command->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return $this->jwtManager->create($user);
    }
}
