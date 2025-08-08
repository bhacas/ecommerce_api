<?php

namespace App\Catalog\Application\Command;

readonly class AddProductMessage
{
    public function __construct(
        public string $name,
        public int $price,
        public string $currency,
        public int $initialStock,
        public ?string $description,
    ) {
    }
}
