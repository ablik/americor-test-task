<?php

namespace App\Application\Handler;

use App\Application\Command\UpdateCustomerCommand;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;

class UpdateCustomerHandler
{
    private CustomerRepositoryInterface $clientRepository;

    public function __construct(CustomerRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function handle(UpdateCustomerCommand $command): void
    {
        $customer = $this->clientRepository->findById($command->ssn);

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

        $this->clientRepository->save($customer);
    }
}