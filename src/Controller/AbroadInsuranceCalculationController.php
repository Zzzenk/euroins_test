<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AbroadInsuranceCalculationDTO;
use App\Service\AbroadInsuranceCalculationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AbroadInsuranceCalculationController extends AbstractController
{
    #[Route('/insurance/abroad/calculate', name: 'calculate', methods: ['GET'])]
    public function calculate(
        AbroadInsuranceCalculationService $abroadInsuranceCalculation,
        Request $request,
    ): JsonResponse {
        $insuranceSum = (int) $request->get('insuranceAmount');
        $tripDateFrom = (string) $request->get('startDate');
        $tripDateTo = (string) $request->get('endDate');
        $currencyCode = (string) $request->get('currencyCode');

        $abroadInsuranceCalculationDTO = new AbroadInsuranceCalculationDTO(
            $insuranceSum,
            new \DateTimeImmutable($tripDateFrom),
            new \DateTimeImmutable($tripDateTo),
            $currencyCode,
        );

        try {
            $result = $abroadInsuranceCalculation->calculate($abroadInsuranceCalculationDTO);
        } catch (\Throwable $exception) {
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse($result);
    }
}
