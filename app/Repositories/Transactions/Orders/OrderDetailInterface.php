<?php

namespace App\Repositories\Transactions\Orders;

interface OrderDetailInterface
{
    public function getOrderDetailsByOrderId($orderId);
}