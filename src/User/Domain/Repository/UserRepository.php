<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Model\User;
use Symfony\Component\Uid\Uuid;

interface UserRepository
{
    public function findByEmail(string $email): ?User;

    public function findByUuid(Uuid $uuid): ?User;

    public function save(User $user): void;
}
