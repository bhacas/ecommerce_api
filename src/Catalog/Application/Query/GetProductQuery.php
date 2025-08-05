<?php

namespace App\Catalog\Application\Query;

use Symfony\Component\Uid\Uuid;

class GetProductQuery
{
    public function __construct(private readonly Uuid $uuid)
    {
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}
