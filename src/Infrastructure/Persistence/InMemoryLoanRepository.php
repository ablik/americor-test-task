<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Loan\Loan;
use App\Domain\Loan\LoanRepositoryInterface;

class InMemoryLoanRepository implements LoanRepositoryInterface
{
    /**
     * @var array<string, Loan> $loans
     */
    private array $loans = [];

    public function save(Loan $loan): void
    {
        $this->loans[$loan->getProductName()] = $loan;
    }

    public function findByName(string $productName): ?Loan
    {
        return $this->loans[$productName] ?? null;
    }
}