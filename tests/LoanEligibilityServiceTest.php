<?php

namespace App\Tests;

use App\Domain\Customer\Customer;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;
use App\Domain\Loan\LoanEligibilityService;
use PHPUnit\Framework\TestCase;

class LoanEligibilityServiceTest extends TestCase
{
    private LoanEligibilityService $service;

    protected function setUp(): void
    {
        $this->service = new LoanEligibilityService();
    }

    public function testCustomerWithLowFicoScoreIsNotEligible(): void
    {
        $customer = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(400),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($customer, 2000));
    }

    public function testCustomerWithLowIncomeIsNotEligible(): void
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
        $this->assertFalse($this->service->isEligible($customer, 500));
    }

    public function testCustomerWithAgeOutsideRangeIsNotEligible(): void
    {
        $customer = new Customer(
            'John',
            'Doe',
            17,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($customer, 2000));

        $customer = new Customer(
            'John',
            'Doe',
            61,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($customer, 2000));
    }

    public function testCustomerOutsideEligibleStatesIsNotEligible(): void
    {
        $customer = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'TX', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($customer, 2000));
    }

    public function testCustomerInNYCanBeRandomlyDenied(): void
    {
        $customer = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'NY', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );

        // Test multiple times to ensure randomness is covered
        $results = [];
        for ($i = 0; $i < 10; $i++) {
            $results[] = $this->service->isEligible($customer, 2000);
        }

        $this->assertContains(false, $results);
        $this->assertContains(true, $results);
    }

    public function testCustomerInCACalculatesCorrectInterestRate(): void
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
        $baseRate = 5.00;

        $expectedRate = $baseRate + 11.49;
        $this->assertEquals($expectedRate, $this->service->calculateInterestRate($customer, $baseRate));
    }

    public function testCustomerNotInCACalculatesCorrectInterestRate(): void
    {
        $customer = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'NV', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $baseRate = 5.00;

        $expectedRate = $baseRate;
        $this->assertEquals($expectedRate, $this->service->calculateInterestRate($customer, $baseRate));
    }
}