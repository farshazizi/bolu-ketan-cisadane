<?php

namespace App\Repositories\Transactions\Orders;

use App\Models\Transactions\Orders\OrderAdditionalDetail;

class OrderAdditionalDetailRepository implements OrderAdditionalDetailInterface
{
    public function getOrderAdditionalDetails($orderDetailId)
    {
        $orderAdditionalDetails = OrderAdditionalDetail::with('additional')
            ->where('order_detail_id', $orderDetailId)
            ->get();

        return $orderAdditionalDetails;
    }
}
