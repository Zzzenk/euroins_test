<?php

declare(strict_types=1);

namespace App\Service;

class AbroadInsuranceCalculationService
{
    public function __construct(
        private ExchangeRateGettingService $exchangeRateGettingService,
    ) {
    }

    /**
     * @return array<string, mixed>
     *
     * @throws \Exception
     */
    public function calculate(AbroadInsuranceCalculationDTO $dto): array
    {
        $oneDayCoefficient = $this->getOneDayCoefficient($dto->getInsuranceAmount());
        $tripInDays = $dto->getStartDate()->diff($dto->getEndDate())->days + 1;
        $costInCurrency = $this->calculateCostInCurrency($oneDayCoefficient, $tripInDays);
        $exchangeRate = $this->exchangeRateGettingService->getExchangeRate($dto->getCurrencyCode());
        $costInRub = $costInCurrency * $exchangeRate;

        return [
            'Общая стоимость в валюте страхования (float)' => $costInCurrency,
            'Общая стоимость в рублях (float)' => $costInRub,
            'Количество дней поездки (int)' => $tripInDays,
            'Коэффициент 1 дня (float)' => $oneDayCoefficient,
            'Курс валюты на сегодняшний день (float)' => $exchangeRate,
            'Страховая сумма (int)' => $dto->getInsuranceAmount(),
        ];
    }

    /**
     * @throws \Exception
     */
    private function getOneDayCoefficient(int $insuranceSum): float
    {
        return match ($insuranceSum) {
            30000 => 0.6,
            50000 => 0.8,
            default => throw new \Exception('Incorrect insurance sum'),
        };
    }

    private function calculateCostInCurrency(float $oneDayCoefficient, int $tripInDays): float
    {
        return round($oneDayCoefficient * $tripInDays, 1);
    }
}
