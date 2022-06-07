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
     * Return the sum all item total value
    **/
    public function getOrderExportInformation(): void
    {
        // Calculate Order Value And analyse
        $orderTotalValue = 0;
        $totalUnitCount = 0;
        $distinctUnitCount = 0;
        foreach ($this->items as $item) {
            // Calculate the order value before discount
            $orderTotalValue += $item->getItemTotalValue();
            // Calculate total number of units in the order
            $totalUnitCount += $item->getQuantity();
            // Unique units in the order
            $distinctUnitCount += 1;
        }
        // Get average Price
        $averageUnitPrice = $orderTotalValue / $totalUnitCount;

        // Calculate and Apply Discount
        $discount_list = array();

        // Sort the discount list by priority
        foreach ($this->discounts as $discount) {
            $discount_list[$discount->getPriority()] = $discount;
        }

        // Apply discount by priority and type
        foreach ($discount_list as $discount) {
            // Case: Dollar, make sure
            if ($discount->getType() == "DOLLAR" and $orderTotalValue >= $discount->getValue()) {
                $orderTotalValue -= $discount->getValue();
            } // Case: Dollar Discount Value > Order Value, Make Order Value to Zero
            else if ($orderTotalValue < $discount->getValue()) {
                $orderTotalValue = 0;
            } // Case: Percentage Convert the percentage to cart discount percentage
            else if ($discount->getType() == "PERCENTAGE") {
                $orderTotalValue *= (1 - ($discount->getValue() / 100));
            }
        }
        // TODO: Return OrderExport Class
    }


    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return get_object_vars($this);
    }
}