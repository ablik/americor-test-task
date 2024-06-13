<?php

namespace App\Domain\Loan;

use App\Domain\Customer\Customer;

class LoanEligibilityService
{
    /**
     * Minimum acceptable credit rating for issuing a loan.
     */
    private const CREDIT_RATING = 500;

    /**
     * Customer's monthly income to accept loan.
     */
    private const MONTHLY_INCOME = 1000;

    /**
     * Customer's minimum age.
     */
    private const MIN_AGE = 18;

    /**
     * Customer's maximum age.
    */
    private const MAX_AGE = 60;

    /**
     * Special interest rate for California state.
     */
    private const CA_SPECIAL_INTEREST_RATE = 11.49;


    public function isEligible(Customer $customer, int $monthlyIncome): bool
    {
        if ($customer->getFico()->getScore() <= self::CREDIT_RATING) {
            return false;
        }

        if ($monthlyIncome < self::MONTHLY_INCOME) {
            return false;
        }

        if ($customer->getAge() < self::MIN_AGE || $customer->getAge() > self::MAX_AGE) {
            return false;
        }

        if (!in_array($customer->getAddress()->getState(), ['CA', 'NY', 'NV'])) {
            return false;
        }

        if ($customer->getAddress()->getState() === 'NY' && rand(0, 1) === 0) {
            return false;
        }

        return true;
    }

    public function calculateInterestRate(Customer $customer, float $baseRate): float
    {
        if ($customer->getAddress()->getState() === 'CA') {
            return $baseRate + self::CA_SPECIAL_INTEREST_RATE;
        }

        return $baseRate;
    }
}