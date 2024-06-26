<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;

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
        $this->customers['123-45-6789'] = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );

        return $this->customers[$ssn] ?? null;
    }
}