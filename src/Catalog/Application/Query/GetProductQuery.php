<?php

namespace App\Catalog\Application\Query;

use Symfony\Component\Uid\Uuid;

readonly class GetProductQuery
{
    public function __construct(private Uuid $uuid)
    {
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }
}
