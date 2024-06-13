<?php

namespace App\Tests;

use App\Application\Command\CreateCustomerCommand;
use App\Application\Handler\CreateCustomerHandler;
use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateCustomerHandlerTest extends TestCase
{
    public function testCreateCustomer(): void
    {
        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Customer::class));

        $handler = new CreateCustomerHandler($repository);

        $command = new CreateCustomerCommand(
            'John',
            'Doe',
            30,
            'City',
            'CA',
            '12345',
            '123-45-6789',
            600,
            'john.doe@example.com',
            '555-555-5555'
        );

        $handler->handle($command);
    }
}