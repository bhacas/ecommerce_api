<?php

namespace App\User\Domain\Model;

use App\User\Infrastructure\Doctrine\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    #[ORM\Column(length: 100)]
    private string $email;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    public function __construct(string $email, array $roles)
    {
        $this->uuid = Uuid::v7();
        $this->email = $email;
        $this->roles = $roles;
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function password(): ?string
    {
        return $this->password;
    }
}
