<?php

namespace App\Application\Command;

class IssueLoanCommand
{
    public string $ssn;
    public string $productName;

    public int $term;

    public int $amount;

    public function __construct(string $ssn, string $productName, int $term, int $amount) {
        $this->ssn = $ssn;
        $this->productName = $productName;
        $this->term = $term;
        $this->amount = $amount;
    }

}