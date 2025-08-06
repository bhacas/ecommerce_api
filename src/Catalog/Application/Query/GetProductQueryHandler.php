<?php

namespace App\Catalog\Application\Query;

use App\Catalog\Application\DTO\ProductView;
use App\Catalog\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final class GetProductQueryHandler
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(GetProductQuery $query): ProductView
    {
        $product = $this->productRepository->findByUuid($query->uuid());

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return ProductView::fromEntity($product);
    }
}
