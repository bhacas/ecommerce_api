<?php

namespace App\Shared\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
readonly class Price
{
    #[ORM\Column(type: 'integer')]
    private int $amount;

    #[ORM\Column(type: 'string', length: 3)]
    private string $currency;

    public function __construct(int $amount, string $currency)
    {
        Assert::greaterThanEq($amount, 0, 'Price amount cannot be negative.');
        Assert::length($currency, 3, 'Currency code must be 3 characters long.');

        $this->amount = $amount;
        $this->currency = strtoupper($currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function equals(Price $other): bool
    {
        return $this->amount === $other->getAmount() && $this->currency === $other->getCurrency();
    }

    public function format(): string
    {
        return sprintf('%0.2f %s', $this->amount / 100, $this->currency);
    }
}
