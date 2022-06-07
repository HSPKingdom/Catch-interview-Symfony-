<?php

namespace App\Controller\DTO;


use JsonSerializable;

class OrderItem implements JsonSerializable
{

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $unitPrice;

    /**
     * @var ProductInformation
     */
    private $product;

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /**
     * @param float $unitPrice
     */
    public function setUnitPrice(float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return ProductInformation
     */
    public function getProduct(): ProductInformation
    {
        return $this->product;
    }

    /**
     * @param ProductInformation $product
     */
    public function setProduct(ProductInformation $product): void
    {
        $this->product = $product;
    }

    /**
     * Calculate and return total value of item
     * Quantity * Unit_Price
     *
     * @return float
     */
    public function getItemTotalValue(): float
    {
        return $this->quantity * $this->unitPrice;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}