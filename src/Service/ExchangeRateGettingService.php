<?php

declare(strict_types=1);

namespace App\Service;

class ExchangeRateGettingService
{
    private const USD = 'USD';
    private const EUR = 'EUR';

    /**
     * @throws \Exception
     */
    public function getExchangeRate(string $currency): float
    {
        return match ($currency) {
            self::USD => 70,
            self::EUR => 80,
            default => throw new \Exception('Unsupported currency'),
        };
    }
}
