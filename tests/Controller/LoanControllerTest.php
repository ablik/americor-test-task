<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoanControllerTest extends WebTestCase
{
    public function testCheckLoanEligibility(): void
    {
        $client = static::createClient();
        $client->request('POST', '/loans/check-eligibility', [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'ssn' => '123-45-6789',
                'monthlyIncome' => 2000,
            ])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('eligible', $data);
    }

    public function testIssueLoan(): void
    {
        $client = static::createClient();
        $client->request('POST', '/loans/issue', [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'ssn' => '123-45-6789',
                'productName' => 'Personal Loan',
                'term' => 36,
                'amount' => 10000,
            ])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}