<?php

namespace App\Controller\DTO;

use DateTime;

class OrderExport
{
    /**
     * @var int
     */
    private $order_id;

    /**
     * @var ?string
     */
    private $order_datetime;

    /**
     * @var float
     */
    private $total_order_value;

    /**
     * @var float
     */
    private $average_unit_price;

    /**
     * @var int
     */
    private $distinct_unit_count;

    /**
     * @var int
     */
    private $total_units_count;

    /**
     * @var ?string
     */
    private $customer_state;


    /**
     * @param int $order_id
     * @param ?string $order_datetime
     * @param float $total_order_value
     * @param float $average_unit_price
     * @param int $distinct_unit_count
     * @param int $total_units_count
     * @param string|null $customer_state
     */
    public function __construct(int $order_id, ?string $order_datetime, float $total_order_value, float $average_unit_price, int $distinct_unit_count, int $total_units_count, ?string $customer_state)
    {
        $this->order_id = $order_id;
        $this->order_datetime = $order_datetime;
        $this->total_order_value = $total_order_value;
        $this->average_unit_price = $average_unit_price;
        $this->distinct_unit_count = $distinct_unit_count;
        $this->total_units_count = $total_units_count;
        $this->customer_state = $customer_state;
    }


    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
    }

    /**
     * @return string|null
     */
    public function getOrderDatetime(): ?string
    {
        return $this->order_datetime;
    }

    /**
     * @param string|null $order_datetime
     */
    public function setOrderDatetime(?string $order_datetime): void
    {
        $this->order_datetime = $order_datetime;
    }


    /**
     * @return float
     */
    public function getTotalOrderValue(): float
    {
        return $this->total_order_value;
    }

    /**
     * @param float $total_order_value
     */
    public function setTotalOrderValue(float $total_order_value): void
    {
        $this->total_order_value = $total_order_value;
    }

    /**
     * @return float
     */
    public function getAverageUnitPrice(): float
    {
        return $this->average_unit_price;
    }

    /**
     * @param float $average_unit_price
     */
    public function setAverageUnitPrice(float $average_unit_price): void
    {
        $this->average_unit_price = $average_unit_price;
    }

    /**
     * @return int
     */
    public function getDistinctUnitCount(): int
    {
        return $this->distinct_unit_count;
    }

    /**
     * @param int $distinct_unit_count
     */
    public function setDistinctUnitCount(int $distinct_unit_count): void
    {
        $this->distinct_unit_count = $distinct_unit_count;
    }

    /**
     * @return int
     */
    public function getTotalUnitsCount(): int
    {
        return $this->total_units_count;
    }

    /**
     * @param int $total_units_count
     */
    public function setTotalUnitsCount(int $total_units_count): void
    {
        $this->total_units_count = $total_units_count;
    }

    /**
     * @return string|null
     */
    public function getCustomerState(): ?string
    {
        return $this->customer_state;
    }

    /**
     * @param string|null $customer_state
     */
    public function setCustomerState(?string $customer_state): void
    {
        $this->customer_state = $customer_state;
    }


}