<?php

namespace App\Controller\DTO;

use JsonSerializable;

class CustomerInformation implements JsonSerializable
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var ?string
     */
    private $firstName;

    /**
     * @var ?string
     */
    private $lastName;

    /**
     * @var ?string
     */
    private $email;

    /**
     * @var ?string
     */
    private $phone;

    /**
     * @var ShippingInformation
     */
    private $shipping_address;


    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     */
    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return ShippingInformation
     */
    public function getShippingAddress(): ShippingInformation
    {
        return $this->shipping_address;
    }

    /**
     * @param ShippingInformation $shipping_address
     */
    public function setShippingAddress(ShippingInformation $shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return get_object_vars($this);
    }
}