<?php

namespace App\Catalog\Infrastructure\Doctrine;

use App\Catalog\Domain\Model\Product;
use App\Catalog\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByUuid(Uuid $uuid): ?Product
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }

    /**
     * @return Collection<int, Product>
     */
    public function findAllAsCollection(): Collection
    {
        $productsArray = parent::findAll();

        return new ArrayCollection($productsArray);
    }
}
