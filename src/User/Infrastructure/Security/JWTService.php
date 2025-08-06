<?php

namespace App\User\Infrastructure\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class JWTService
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function createToken(UserInterface $user): string
    {
        return $this->jwtManager->create($user);
    }
}
