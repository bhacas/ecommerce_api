<?php

namespace App\Catalog\Application\Query;

use Webmozart\Assert\Assert;

readonly class GetProductsQuery
{
    public function __construct(private string $orderBy = 'name', private string $orderDirection = 'asc')
    {
    }

    public function orderBy(): string
    {
        Assert::oneOf($this->orderBy, ['name', 'price', 'createdAt'], 'Invalid order by field.');

        return $this->orderBy;
    }

    public function orderDirection(): string
    {
        Assert::oneOf($this->orderDirection, ['asc', 'desc'], 'Invalid order direction.');

        return $this->orderDirection;
    }
}
