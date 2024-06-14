<?php

namespace App\UI\REST;

use App\Application\Command\CheckLoanEligibilityCommand;
use App\Application\Handler\CheckLoanEligibilityHandler;
use App\Application\Command\IssueLoanCommand;
use App\Application\Handler\IssueLoanHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoanController
{
    private CheckLoanEligibilityHandler $checkLoanEligibilityHandler;
    private IssueLoanHandler $issueLoanHandler;

    public function __construct(
        CheckLoanEligibilityHandler $checkLoanEligibilityHandler, IssueLoanHandler $issueLoanHandler
    ) {
        $this->checkLoanEligibilityHandler = $checkLoanEligibilityHandler;
        $this->issueLoanHandler = $issueLoanHandler;
    }

    /**
     * @Route("/loans/check-eligibility", methods={"POST"})
     */
    public function checkEligibility(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CheckLoanEligibilityCommand(
            $data['ssn'],
            $data['monthlyIncome']
        );

        $result = $this->checkLoanEligibilityHandler->handle($command);

        return new JsonResponse(['eligible' => $result], 200);
    }

    /**
     * @Route("/loans/issue", methods={"POST"})
     */
    public function issue(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new IssueLoanCommand(
            $data['ssn'],
            $data['productName'],
            $data['term'],
            $data['amount']
        );

        $this->issueLoanHandler->handle($command);

        return new JsonResponse(['status' => 'Loan issued'], 201);
    }
}