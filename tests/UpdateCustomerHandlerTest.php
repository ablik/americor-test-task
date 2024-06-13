<?php

namespace App\Tests;

use App\Application\Command\UpdateCustomerCommand;
use App\Application\Handler\UpdateCustomerHandler;
use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;
use PHPUnit\Framework\TestCase;

class UpdateCustomerHandlerTest extends TestCase
{
    public function testUpdateCustomer(): void
    {
        $customer = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );

        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $repository->method('findById')->willReturn($customer);
        $repository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Customer::class));

        $handler = new UpdateCustomerHandler($repository);

        $command = new UpdateCustomerCommand(
            'Jane',
            'Doe',
            32,
            'New City',
            'NY',
            '54321',
            '123-45-6789',
            700,
            'jane.doe@example.com',
            '555-555-5556'
        );

        $handler->handle($command);

        $this->assertEquals('Jane', $customer->getFirstName());
        $this->assertEquals('Doe', $customer->getLastName());
        $this->assertEquals(32, $customer->getAge());
        $this->assertEquals('New City', $customer->getAddress()->getCity());
        $this->assertEquals('NY', $customer->getAddress()->getState());
        $this->assertEquals('54321', $customer->getAddress()->getZipCode());
        $this->assertEquals(700, $customer->getFico()->getScore());
        $this->assertEquals('jane.doe@example.com', $customer->getEmail());
        $this->assertEquals('555-555-5556', $customer->getPhoneNumber());
    }
}
