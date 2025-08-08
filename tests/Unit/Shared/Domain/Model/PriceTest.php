<?php

namespace App\Tests\Unit\Shared\Domain\Model;

use App\Shared\Domain\Model\Price;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class PriceTest extends TestCase
{
    public function testItCanBeCreatedWithValidData(): void
    {
        // Arrange
        $amount = 1000; // 10.00
        $currency = 'pln';

        // Act
        $price = new Price($amount, $currency);

        // Assert
        $this->assertSame($amount, $price->getAmount());
        $this->assertSame('PLN', $price->getCurrency(), 'Currency should be converted to uppercase.');
    }

    public function testItCannotBeCreatedWithANegativeAmount(): void
    {
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Price amount cannot be negative.');

        // Act
        new Price(-100, 'PLN');
    }

    public function testItCanBeCreatedWithZeroAmount(): void
    {
        // Act
        $price = new Price(0, 'PLN');

        // Assert
        $this->assertSame(0, $price->getAmount());
        $this->assertSame('PLN', $price->getCurrency());
    }

    #[DataProvider('invalidCurrencyProvider')]
    public function testItCannotBeCreatedWithAnInvalidCurrencyCode(string $invalidCurrency): void
    {
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency code must be 3 characters long.');

        // Act
        new Price(1000, $invalidCurrency);
    }

    public static function invalidCurrencyProvider(): array
    {
        return [
            'Too short' => ['PL'],
            'Too long' => ['PLNN'],
            'Empty' => [''],
        ];
    }

    public function testItCanBeComparedToAnotherPrice(): void
    {
        // Arrange
        $price1 = new Price(2550, 'PLN');
        $price2 = new Price(2550, 'PLN');
        $price3 = new Price(3000, 'PLN');
        $price4 = new Price(2550, 'EUR');

        // Assert
        $this->assertTrue($price1->equals($price2), 'Prices with same amount and currency should be equal.');
        $this->assertFalse($price1->equals($price3), 'Prices with different amounts should not be equal.');
        $this->assertFalse($price1->equals($price4), 'Prices with different currencies should not be equal.');
    }

    #[DataProvider('formatDataProvider')]
    public function testItCanBeFormattedToString(int $amount, string $currency, string $expectedFormat): void
    {
        // Arrange
        $price = new Price($amount, $currency);

        // Act
        $formattedPrice = $price->format();

        // Assert
        $this->assertSame($expectedFormat, $formattedPrice);
    }

    public static function formatDataProvider(): array
    {
        return [
            'Standard price' => [12345, 'PLN', '123.45 PLN'],
            'Price below 1' => [99, 'USD', '0.99 USD'],
            'Zero price' => [0, 'EUR', '0.00 EUR'],
            'Price with single digit cents' => [1205, 'CHF', '12.05 CHF'],
        ];
    }
}
