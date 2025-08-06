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

        $this->assertSame($email, $user->email());
        $this->assertSame($roles, $user->roles());
        $this->assertNotNull($user->uuid());
    }
}
