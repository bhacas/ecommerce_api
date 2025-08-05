<?php

namespace App\User\Application\QueryHandler;

use App\Shared\Application\Bus\QueryHandlerInterface;
use App\User\Application\Dto\UserDto;
use App\User\Application\Query\GetLoggedUserQuery;
use App\User\Domain\Repository\UserRepository;

readonly class GetLoggedUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(private UserRepository $userRepository) {}

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
