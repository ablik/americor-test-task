<?php

namespace App\Domain\Loan;

class Loan
{
    /**
     * Name of the product or service.
     */
    private string $productName;

    /**
     * Loan term in months.
     */
    private int $term;

    /**
     * Actual interest rate for product.
     */
    private float $interestRate;

    /**
     * Loan amount.
     */
    private float $amount;

    public function __construct(string $productName, int $term, float $interestRate, float $amount)
    {
        $this->productName = $productName;
        $this->term = $term;
        $this->interestRate = $interestRate;
        $this->amount = $amount;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}