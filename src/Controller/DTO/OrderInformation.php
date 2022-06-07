<?php

namespace App\Controller\DTO;

use DateTime;
use JsonSerializable;

class OrderInformation implements JsonSerializable
{
    /**
     * @var int
     */
    private $orderId;

    /**
     * @var ?string
     */
    private $orderDate;

    /**
     * @var CustomerInformation
     */
    private $customer;

    /**
     * @var OrderItem[]
     */
    private $items = [];

    /**
     * @var OrderDiscount[]
     */
    private $discounts = [];

    /**
     * @var ?float
     */
    private $shippingPrice;

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string|null
     */
    public function getOrderDate(): ?string
    {
        return $this->orderDate;
    }

    /**
     * @param string|null $orderDate
     */
    public function setOrderDate(?string $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return OrderDiscount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    /**
     * @param OrderDiscount[] $discounts
     */
    public function setDiscounts(array $discounts): void
    {
        $this->discounts = $discounts;
    }

    /**
     * @return float|null
     */
    public function getShippingPrice(): ?float
    {
        return $this->shippingPrice;
    }

    /**
     * @param float|null $shippingPrice
     */
    public function setShippingPrice(?float $shippingPrice): void
    {
        $this->shippingPrice = $shippingPrice;
    }

    /**
     * @return CustomerInformation|null
     */
    public function getCustomer(): ?CustomerInformation
    {
        return $this->customer;
    }

    /**
     * @param CustomerInformation|null $customer
     */
    public function setCustomer(?CustomerInformation $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return get_object_vars($this);
    }
}