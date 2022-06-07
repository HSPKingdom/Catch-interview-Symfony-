<?php

namespace App\Tests\Controller\DTO;

use App\Controller\DTO\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
    public function testCorrectItemTotalValueReturned()
    {
        $orderItem = new OrderItem();

        $orderItem->setQuantity(25);
        $orderItem->setUnitPrice(15.99);

        $itemTotalValue = $orderItem->getItemTotalValue();

        $this->assertEquals(399.75, $itemTotalValue);
    }
}
