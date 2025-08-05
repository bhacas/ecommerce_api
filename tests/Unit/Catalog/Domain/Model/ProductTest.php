<?php

namespace App\Tests\Unit\Catalog\Domain\Model;

use App\Catalog\Domain\Model\Product;
use App\Shared\Domain\Model\Price;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ProductTest extends TestCase
{
    public function testProductIsInstantiatedCorrectlyWithConstructor(): void
    {
        $productName = 'Nowoczesna Klawiatura';
        $price = new Price(34999, 'PLN'); // 349.99 PLN
        $stock = 50;

        $product = new Product($productName, $price, $stock);


        $this->assertInstanceOf(Uuid::class, $product->getUuid());

        $this->assertSame($productName, $product->getName());

        $this->assertSame($price, $product->getPrice());
        $this->assertSame(34999, $product->getPrice()->getAmount());
        $this->assertSame('PLN', $product->getPrice()->getCurrency());

        $this->assertSame($stock, $product->getStock());

        $this->assertNull($product->getDescription());
    }
}
