<?php

namespace App\Application\Handler;

use App\Application\Command\CheckLoanEligibilityCommand;
use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;
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
        $customer = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );

        return $this->loanEligibilityService->isEligible($customer, $command->monthlyIncome);
    }
}