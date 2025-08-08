<?php

namespace App\Catalog\Application\Command;

use App\Catalog\Domain\Model\Product;
use App\Catalog\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class AddProductMessageHandler
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(AddProductMessage $message): void
    {
        $product = Product::create(
            $message->name,
            $message->price,
            $message->currency,
            $message->description,
            $message->initialStock
        );

        $this->productRepository->save($product);
    }
}
