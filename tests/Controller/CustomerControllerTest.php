<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{
    public function testCreateCustomer(): void
    {
        $client = static::createClient();
        $client->request('POST', '/customers', [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'firstName' => 'John',
                'lastName' => 'Doe',
                'age' => 30,
                'city' => 'City',
                'state' => 'CA',
                'zipCode' => '12345',
                'ssn' => '123-45-6789',
                'fico' => 600,
                'email' => 'john.doe@example.com',
                'phoneNumber' => '555-555-5555',
            ])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testUpdateCustomer(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/customers/123-45-6789', [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'age' => 32,
                'city' => 'New City',
                'state' => 'NY',
                'zipCode' => '54321',
                'fico' => 700,
                'email' => 'jane.doe@example.com',
                'phoneNumber' => '555-555-5556',
            ])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}