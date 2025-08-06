<?php

namespace App\User\Application\Query;

readonly class GetLoggedUserQuery
{
    public function __construct(
        public string $email,
    ) {
    }
}
