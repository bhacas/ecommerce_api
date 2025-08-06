<?php

namespace App\User\Application\Dto;

class UserDto
{
    public function __construct(
        public string $uuid,
        public string $email,
        public string $role,
    ) {
    }
}
