<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;

class InMemoryCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var array<string, Customer> $customers
    */
    private array $customers = [];

    public function save(Customer $customer): void
    {
        $this->customers[$customer->getSsn()->getValue()] = $customer;
    }

    public function findById(string $ssn): ?Customer
    {
        return $this->customers[$ssn] ?? null;
    }
}