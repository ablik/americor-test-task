<?php

namespace App\Application\Handler;

use App\Application\Command\UpdateCustomerCommand;
use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;

class UpdateCustomerHandler
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function handle(UpdateCustomerCommand $command): void
    {
         $customer = $this->customerRepository->findById($command->ssn);

         if (!$customer) {
             throw new \Exception('Customer not found.');
         }

        $customer->updateDetails(
            $command->firstName,
            $command->lastName,
            $command->age,
            new Address($command->city, $command->state, $command->zipCode),
            new FICO($command->fico),
            $command->email,
            $command->phoneNumber
        );

        $this->customerRepository->save($customer);
    }
}