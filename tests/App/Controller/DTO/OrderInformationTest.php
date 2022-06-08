<?php

namespace App\Tests\Controller\DTO;

use App\Controller\DTO\CustomerInformation;
use App\Controller\DTO\OrderDiscount;
use App\Controller\DTO\OrderExport;
use App\Controller\DTO\OrderInformation;
use App\Controller\DTO\OrderItem;
use App\Controller\DTO\ShippingInformation;
use DateTime;
use PHPUnit\Framework\TestCase;

class OrderInformationTest extends TestCase
{

    public function testCorrectOrderExportReturn()
    {
        $orderInformation = new OrderInformation();
        $orderDate = new DateTime("Fri, 08 Mar 2019 13:45:01 +0000");

        $orderInformation->setOrderId(1000);
        $orderInformation->setOrderDate($orderDate->format(DateTime::ISO8601));

        $orderItem = new OrderItem();
        $orderItem->setQuantity(2);
        $orderItem->setUnitPrice(15.99);

        $orderItem2 = new OrderItem();
        $orderItem2->setQuantity(3);
        $orderItem2->setUnitPrice(100);

        $orderInformation->setItems(array($orderItem, $orderItem2));

        $orderDiscount = new OrderDiscount();
        $orderDiscount->setValue('10');
        $orderDiscount->setType('DOLLAR');
        $orderDiscount->setPriority(2);

        $orderDiscount2 = new OrderDiscount();
        $orderDiscount2->setValue('10');
        $orderDiscount2->setType('PERCENTAGE');
        $orderDiscount2->setPriority(1);

        $shippingAddress = new ShippingInformation();
        $shippingAddress->setState("TEST");

        $customer = new CustomerInformation();
        $customer->setCustomerId(1234);
        $customer->setShippingAddress($shippingAddress);
        $orderInformation->setCustomer($customer);


        $orderInformation->setDiscounts(array($orderDiscount, $orderDiscount2));

        $testOrderExport = $orderInformation->getOrderExportInformation();

        $orderExport = new OrderExport(1000, $orderDate->format(DateTime::ISO8601), 289.782, 66.396, 2,5,"TEST");

        $this->assertEquals($testOrderExport, $orderExport);
    }

}
