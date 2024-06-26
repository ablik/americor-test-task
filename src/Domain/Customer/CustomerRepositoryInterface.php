<?php

namespace App\Domain\Customer;

interface CustomerRepositoryInterface
{
    public function save(Customer $customer): void;

    public function findById(string $ssn): ?Customer;
}