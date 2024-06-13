<?php

namespace App\Infrastructure\Notification;

use App\Domain\Customer\Customer;
use App\Domain\Loan\Loan;

class EmailNotifier
{
    public function notify(Customer $customer, Loan $loan): void
    {
        echo "Email sent to {$customer->getEmail()} about loan {$loan->getProductName()}\n";
    }
}
