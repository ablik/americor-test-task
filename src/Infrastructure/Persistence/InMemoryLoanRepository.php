<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Loan\Loan;
use App\Domain\Loan\LoanRepositoryInterface;

class InMemoryLoanRepository implements LoanRepositoryInterface
{
    private array $loans = [];

    public function save(Loan $loan): void
    {
        $this->loans[] = $loan;
    }
}