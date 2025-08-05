<?php

namespace App\Catalog\Application\DTO;

use App\Catalog\Domain\Model\Product;
use Symfony\Component\Uid\Uuid;

final class ProductView
{
    public string $id;

    public string $name;
    public ?string $description;
    public int $stock;
    public string $formattedPrice;

    public static function fromEntity(Product $product): self
    {
        $view = new self();
        $view->id = (string) $product->getUuid();
        $view->name = $product->getName();
        $view->description = $product->getDescription();
        $view->stock = $product->getStock();

        $priceObject = $product->getPrice();
        $amountInZloty = number_format($priceObject->getAmount() / 100, 2, ',', '');
        $view->formattedPrice = sprintf('%s %s', $amountInZloty, $priceObject->getCurrency());

        return $view;
    }
}
