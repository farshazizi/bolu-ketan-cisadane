<?php

namespace App\Repositories\Transactions\Orders;

use App\Models\Transactions\Orders\OrderDetail;

class OrderDetailRepository implements OrderDetailInterface
{
    public function getOrderDetailsByOrderId($orderId)
    {
        $orderDetails = OrderDetail::with('inventoryStock')->where('order_id', $orderId)->get();

        return $orderDetails;
    }
}
