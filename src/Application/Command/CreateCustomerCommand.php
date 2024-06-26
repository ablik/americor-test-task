<?php

namespace App\Application\Command;

class CreateCustomerCommand
{
    public string $firstName;
    public string $lastName;
    public int $age;
    public string $city;
    public string $state;
    public string $zipCode;
    public string $ssn;
    public int $fico;
    public string $email;
    public string $phoneNumber;

    public function __construct(
        string $ssn,
        string $firstName,
        string $lastName,
        int $age,
        string $city,
        string $state,
        string $zipCode,
        int $fico,
        string $email,
        string $phoneNumber
    ) {
        $this->ssn = $ssn;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->fico = $fico;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }
}
