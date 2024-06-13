<?php

namespace App\Domain\Loan;

use App\Domain\Customer\Customer;
use App\Infrastructure\Notification\EmailNotifier;
use App\Infrastructure\Notification\SMSNotifier;

class LoanNotificationService
{
    private ?EmailNotifier $emailNotifier;
    private ?SMSNotifier $smsNotifier;

    public function __construct(?EmailNotifier $emailNotifier, ?SMSNotifier $smsNotifier)
    {
        $this->emailNotifier = $emailNotifier;
        $this->smsNotifier = $smsNotifier;
    }

    public function notifyCustomer(Customer $customer, Loan $loan): void
    {
        if ($this->emailNotifier) {
            $this->emailNotifier->notify($customer, $loan);
        }

        if ($this->smsNotifier) {
            $this->smsNotifier->notify($customer, $loan);
        }
    }
}