<?php

namespace App\Application\Handler;

use App\Application\Command\CreateCustomerCommand;
use App\Domain\Customer\Customer;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;
use App\Domain\Customer\CustomerRepositoryInterface;

class CreateCustomerHandler
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function handle(CreateCustomerCommand $command): void
    {
        $customer = new Customer(
            $command->firstName,
            $command->lastName,
            $command->age,
            new Address($command->city, $command->state, $command->zipCode),
            new SSN($command->ssn),
            new FICO($command->fico),
            $command->email,
            $command->phoneNumber
        );

        $this->customerRepository->save($customer);
    }
}
