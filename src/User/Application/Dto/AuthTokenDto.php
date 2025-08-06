<?php

namespace App\User\Application\Dto;

readonly class AuthTokenDto
{
    public function __construct(public string $token)
    {
    }
}
