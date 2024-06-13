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

    public function testClientWithLowFicoScoreIsNotEligible(): void
    {
        $client = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(400),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($client, 2000));
    }

    public function testClientWithLowIncomeIsNotEligible(): void
    {
        $client = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($client, 500));
    }

    public function testClientWithAgeOutsideRangeIsNotEligible(): void
    {
        $client = new Customer(
            'John',
            'Doe',
            17,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($client, 2000));

        $client = new Customer(
            'John',
            'Doe',
            61,
            new Address('City', 'CA', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($client, 2000));
    }

    public function testClientOutsideEligibleStatesIsNotEligible(): void
    {
        $client = new Customer(
            'John',
            'Doe',
            30,
            new Address('City', 'TX', '12345'),
            new SSN('123-45-6789'),
            new FICO(600),
            'john.doe@example.com',
            '555-555-5555'
        );
        $this->assertFalse($this->service->isEligible($client, 2000));
    }

    public function testClientInNYCanBeRandomlyDenied(): void
    {
        $client = new Customer(
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
            $results[] = $this->service->isEligible($client, 2000);
        }

        $this->assertContains(false, $results);
        $this->assertContains(true, $results);
    }

    public function testClientInCACalculatesCorrectInterestRate(): void
    {
        $client = new Customer(
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
        $this->assertEquals($expectedRate, $this->service->calculateInterestRate($client, $baseRate));
    }

    public function testClientNotInCACalculatesCorrectInterestRate(): void
    {
        $client = new Customer(
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
        $this->assertEquals($expectedRate, $this->service->calculateInterestRate($client, $baseRate));
    }
}