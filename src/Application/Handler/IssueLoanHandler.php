<?php

namespace App\Application\Handler;

use App\Application\Command\IssueLoanCommand;
use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;
use App\Domain\Loan\Loan;
use App\Domain\Loan\LoanEligibilityService;
use App\Domain\Loan\LoanNotificationService;
use App\Domain\Loan\LoanRepositoryInterface;

class IssueLoanHandler
{
    private CustomerRepositoryInterface $customerRepository;
    private LoanRepositoryInterface $loanRepository;
    private LoanEligibilityService $loanEligibilityService;
    private LoanNotificationService $loanNotificationService;

    private const BASE_RATE = 5.0;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        LoanRepositoryInterface     $loanRepository,
        LoanEligibilityService      $loanEligibilityService,
        LoanNotificationService     $loanNotificationService
    ) {
        $this->customerRepository = $customerRepository;
        $this->loanRepository = $loanRepository;
        $this->loanEligibilityService = $loanEligibilityService;
        $this->loanNotificationService = $loanNotificationService;
    }

    public function handle(IssueLoanCommand $command): void
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

        $eligible = $this->loanEligibilityService->isEligible($customer, $command->amount);

        if (!$eligible) {
            throw new \Exception('Customer is not eligible for the loan.');
        }

        $interestRate = $this->loanEligibilityService->calculateInterestRate($customer, self::BASE_RATE);

        $loan = new Loan(
            $command->productName,
            $command->term,
            $interestRate,
            $command->amount
        );

        $this->loanRepository->save($loan);
        $this->loanNotificationService->notifyCustomer($customer, $loan);
    }
}