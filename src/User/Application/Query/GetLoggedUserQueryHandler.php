<?php

namespace App\User\Application\Query;

use App\User\Application\Dto\UserDto;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetLoggedUserQueryHandler
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(GetLoggedUserQuery $query): UserDto
    {
        $user = $this->userRepository->findByEmail($query->email);

        return new UserDto(
            uuid: $user->uuid()->toString(),
            email: $user->email(),
            role: method_exists($user, 'roles') ? implode(',', $user->roles()) : 'ROLE_USER'
        );
    }
}
