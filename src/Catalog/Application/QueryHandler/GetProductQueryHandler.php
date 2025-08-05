<?php

namespace App\Catalog\Application\QueryHandler;

use App\Catalog\Application\DTO\ProductView;
use App\Catalog\Application\Query\GetProductQuery;
use App\Catalog\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Bus\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

final class GetProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(GetProductQuery $query): ProductView
    {
        $product = $this->productRepository->findByUuid(Uuid::fromString($query->uuid()));

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return ProductView::fromEntity($product);
    }
}
