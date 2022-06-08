<?php

namespace App\Controller\DTO;


use JsonSerializable;

class ShippingInformation implements JsonSerializable
{

    /**
     * @var ?string
     */
    private $street;

    /**
     * @var ?string
     */
    private $postcode;

    /**
     * @var ?string
     */
    private $suburb;

    /**
     * @var ?string
     */
    private $state;

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string|null
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * @param string|null $postcode
     */
    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string|null
     */
    public function getSuburb(): ?string
    {
        return $this->suburb;
    }

    /**
     * @param string|null $suburb
     */
    public function setSuburb(?string $suburb): void
    {
        $this->suburb = $suburb;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return get_object_vars($this);
    }
}