<?php

namespace App\User\Infrastructure\Security;

use App\User\Domain\Model\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class SymfonyUserAdapter implements UserInterface, PasswordAuthenticatedUserInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserIdentifier(): string
    {
        return $this->user->email();
    }

    public function getRoles(): array
    {
        return $this->user->roles();
    }

    public function getPassword(): ?string
    {
        return $this->user->password();
    }

    public function eraseCredentials(): void
    {
    }
}
