<?php

namespace App\Domain\Customer;

use App\Domain\Customer\ValueObject\Address;
use App\Domain\Customer\ValueObject\FICO;
use App\Domain\Customer\ValueObject\SSN;

class Customer
{
    private string $firstName;
    private string $lastName;
    private int $age;
    private Address $address;
    private SSN $ssn;
    private FICO $fico;
    private string $email;
    private string $phoneNumber;

    public function __construct(
        string $firstName,
        string $lastName,
        int $age,
        Address $address,
        SSN $ssn,
        FICO $fico,
        string $email,
        string $phoneNumber
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->address = $address;
        $this->ssn = $ssn;
        $this->fico = $fico;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function updateDetails(
        string $firstName,
        string $lastName,
        int $age,
        Address $address,
        FICO $fico,
        string $email,
        string $phoneNumber
    ): void {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->address = $address;
        $this->fico = $fico;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getSsn(): SSN
    {
        return $this->ssn;
    }

    public function getFico(): FICO
    {
        return $this->fico;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}