<?php

namespace App\Catalog\Application\Query;

use App\Catalog\Application\DTO\ProductView;
use App\Catalog\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetProductsQueryHandler
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(GetProductsQuery $query): Collection
    {
        $products = $this->productRepository->findAllOrdered(
            orderBy: $query->orderBy(),
            orderDirection: $query->orderDirection()
        );

        return $products->map(fn ($product) => ProductView::fromEntity($product));
    }
}
