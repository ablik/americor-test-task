<?php

namespace App\Infrastructure\Notification;

use App\Domain\Customer\Customer;
use App\Domain\Loan\Loan;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifier
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(Customer $customer, Loan $loan): void
    {
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($customer->getEmail())
            ->subject('Loan Issued')
            ->text(sprintf('Your loan %s has been issued.', $loan->getProductName()));

        $this->mailer->send($email);
    }
}