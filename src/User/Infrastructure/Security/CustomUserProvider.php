<?php

namespace App\User\Infrastructure\Security;

use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class CustomUserProvider implements UserProviderInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * Ta metoda jest wywoływana podczas logowania, aby znaleźć użytkownika
     * na podstawie jego identyfikatora (np. emaila z formularza).
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findByEmail($identifier); // lub inna metoda wyszukująca

        if (!$user) {
            throw new UserNotFoundException(sprintf('User with identifier "%s" not found.', $identifier));
        }

        return new SymfonyUserAdapter($user);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SymfonyUserAdapter) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === SymfonyUserAdapter::class || is_subclass_of($class, SymfonyUserAdapter::class);
    }
}
