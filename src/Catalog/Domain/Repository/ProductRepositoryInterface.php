<?php

namespace App\Catalog\Domain\Repository;

use App\Catalog\Domain\Model\Product;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

interface ProductRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Product;

    /**
     * @return Collection<int, Product>
     */
    public function findAllAsCollection(): Collection;
}
