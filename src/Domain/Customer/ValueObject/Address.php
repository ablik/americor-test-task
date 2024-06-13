<?php

namespace App\Domain\Customer\ValueObject;

class Address
{
    private string $city;
    private string $state;
    private string $zipCode;

    public function __construct(string $city, string $state, string $zipCode)
    {
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }


}