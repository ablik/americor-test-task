<?php

namespace App\Domain\Loan;

interface LoanRepositoryInterface
{
    public function save(Loan $loan): void;
}
