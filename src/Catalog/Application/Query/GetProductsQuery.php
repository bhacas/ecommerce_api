<?php

namespace App\Catalog\Application\Query;

use Webmozart\Assert\Assert;

readonly class GetProductsQuery
{
    public function __construct(
        private int $page = 1,
        private int $limit = 20,
        private string $orderBy = 'name',
        private string $orderDirection = 'asc'
    ) {
    }

    public function page(): int
    {
        Assert::greaterThan($this->page, 0, 'Page number must be greater than 0.');

        return $this->page;
    }

    public function limit(): int
    {
        Assert::greaterThan($this->limit, 0, 'Limit must be greater than 0.');

        return $this->limit;
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
