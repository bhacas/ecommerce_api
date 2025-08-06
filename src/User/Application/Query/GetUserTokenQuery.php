<?php

namespace App\User\Application\Query;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetUserTokenQuery
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6, max: 255)]
        public string $password
    ) {}
}
