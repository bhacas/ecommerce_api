<?php

namespace App\Catalog\Domain\Model;

use App\Catalog\Domain\Infrastructure\Doctrine\ProductRepository;
use App\Shared\Domain\Model\Price;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Embedded(class: Price::class, columnPrefix: false)]
    private Price $price;

    #[ORM\Column]
    private int $stock;

    public function __construct(string $name, Price $price, int $stock)
    {
        $this->uuid = Uuid::v7();
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}
