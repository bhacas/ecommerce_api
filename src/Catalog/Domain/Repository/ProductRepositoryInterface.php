<?php

namespace App\Catalog\Domain\Repository;

use App\Catalog\Domain\Model\Product;
use Symfony\Component\Uid\Uuid;

interface ProductRepositoryInterface
{

    public function findByUuid(Uuid $uuid): ?Product;
}
