<?php

declare(strict_types=1);

namespace App\Service;

class AbroadInsuranceCalculationDTO
{
    public function __construct(
        private int $insuranceAmount,
        private \DateTimeImmutable $startDate,
        private \DateTimeImmutable $endDate,
        private string $currencyCode,
    ) {
    }

    public function getInsuranceAmount(): int
    {
        return $this->insuranceAmount;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}
