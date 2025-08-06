<?php

namespace App\Tests\Unit\User\Domain\Model;

use App\User\Domain\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $email = 'test@example.com';
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $user = new User($email, $roles);

        $this->assertSame($email, $user->getEmail());
        $this->assertSame($roles, $user->getRoles());
        $this->assertNotNull($user->uuid());
    }

    public function testSetRoles(): void
    {
        $user = new User('test@example.com', []);
        $user->setRoles(['ROLE_TEST']);
        $this->assertSame(['ROLE_TEST'], $user->getRoles());
    }

    public function testSetPasswordAndGetPassword(): void
    {
        $user = new User('test@example.com', []);
        $user->setPassword('hashed_password');
        $this->assertSame('hashed_password', $user->getPassword());
    }

    public function testGetUserIdentifier(): void
    {
        $email = 'user@domain.com';
        $user = new User($email, []);
        $this->assertSame($email, $user->getUserIdentifier());
    }
}
