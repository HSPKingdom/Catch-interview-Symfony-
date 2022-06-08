<?php

namespace App\Controller\DTO;


use JsonSerializable;

class ProductBrand implements JsonSerializable
{

    /**
     * @var ?int
     */
    private $id;

    /**
     * @var ?string
     */
    private $name;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return get_object_vars($this);
    }
}