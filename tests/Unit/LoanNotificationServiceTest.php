<?php

namespace App\Tests\Unit;

use App\Domain\Customer\Customer;
use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;
use App\Domain\Loan\Loan;
use App\Domain\Loan\LoanNotificationService;
use App\Infrastructure\Notification\EmailNotifier;
use App\Infrastructure\Notification\SMSNotifier;
use PHPUnit\Framework\TestCase;

class LoanNotificationServiceTest extends TestCase
{
    public function testNotifyCustomerByEmail(): void
    {
        $emailNotifier = $this->createMock(EmailNotifier::class);
        $emailNotifier->expects($this->once())
            ->method('notify')
            ->with($this->isInstanceOf(Customer::class), $this->isInstanceOf(Loan::class));

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

        $loan = new Loan(
            'Personal Loan',
            36,
            5.0,
            10000
        );

        $notificationService = new LoanNotificationService($emailNotifier, null);
        $notificationService->notifyCustomer($customer, $loan);
    }

    public function testNotifyCustomerBySMS(): void
    {
        $smsNotifier = $this->createMock(SMSNotifier::class);
        $smsNotifier->expects($this->once())
            ->method('notify')
            ->with($this->isInstanceOf(Customer::class), $this->isInstanceOf(Loan::class));

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

        $loan = new Loan(
            'Personal Loan',
            36,
            5.0,
            10000
        );

        $notificationService = new LoanNotificationService(null, $smsNotifier);
        $notificationService->notifyCustomer($customer, $loan);
    }
}