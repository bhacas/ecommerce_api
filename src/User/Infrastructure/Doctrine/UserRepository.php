<?php

namespace App\User\Infrastructure\Doctrine;

use App\User\Domain\Model\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;
use App\User\Domain\Repository\UserRepository as UserRepositoryInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->getEntityManager()->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function findByUuid(Uuid $uuid): ?User
    {
        return $this->getEntityManager()->getRepository(User::class)->find($uuid);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
