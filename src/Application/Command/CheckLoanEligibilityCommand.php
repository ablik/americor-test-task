<?php

namespace App\Application\Command;

class CheckLoanEligibilityCommand
{
    public string $ssn;
    public int $monthlyIncome;

    public function __construct(string $ssn, int $monthlyIncome)
    {
        $this->ssn = $ssn;
        $this->monthlyIncome = $monthlyIncome;
    }
}