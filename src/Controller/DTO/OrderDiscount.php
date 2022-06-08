<?php

namespace App\Controller\DTO;

use JsonSerializable;

class OrderDiscount implements JsonSerializable
{

    /**
     * @var ?string
     */
    private $type;

    /**
     * @var ?float
     */
    private $value;

    /**
     * @var ?int
     */
    private $priority;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param float|null $value
     */
    public function setValue(?float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     */
    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return get_object_vars($this);
    }
}