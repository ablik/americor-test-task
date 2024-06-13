<?php

namespace App\Application\Handler;

use App\Application\Command\CheckLoanEligibilityCommand;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Loan\LoanEligibilityService;

class CheckLoanEligibilityHandler
{
    private CustomerRepositoryInterface $customerRepository;
    private LoanEligibilityService $loanEligibilityService;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        LoanEligibilityService $loanEligibilityService
    ) {
        $this->customerRepository = $customerRepository;
        $this->loanEligibilityService = $loanEligibilityService;
    }

    public function handle(CheckLoanEligibilityCommand $command): bool
    {
        $customer = $this->customerRepository->findById($command->ssn);

        if (!$customer) {
            throw new \Exception('Client not found.');
        }

        return $this->loanEligibilityService->isEligible($customer, $command->monthlyIncome);
    }
}