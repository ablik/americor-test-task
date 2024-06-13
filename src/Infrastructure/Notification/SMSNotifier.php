<?php

namespace App\Infrastructure\Notification;

use App\Domain\Customer\Customer;
use App\Domain\Loan\Loan;

class SMSNotifier
{
    public function notify(Customer $customer, Loan $loan): void
    {
        echo "SMS sent to {$customer->getPhoneNumber()} about loan {$loan->getProductName()}\n";
    }
}