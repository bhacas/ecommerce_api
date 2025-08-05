<?php

namespace App\User\Application\Query;

use App\User\Application\Dto\UserDto;
use App\User\Domain\Repository\UserRepository;

class GetLoggedUserHandler
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function __invoke(GetLoggedUserQuery $query): UserDto
    {
        $user = $this->userRepository->findByEmail($query->email);

        return new UserDto(
            uuid: $user->uuid()->toString(),
            email: $user->getEmail(),
            role: method_exists($user, 'getRoles') ? implode(',' , $user->getRoles()) : 'ROLE_USER'
        );
    }
}
