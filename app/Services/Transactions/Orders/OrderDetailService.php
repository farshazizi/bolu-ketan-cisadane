<?php

namespace App\Services\Transactions\Orders;

use App\Repositories\Transactions\Orders\OrderDetailRepository;

class OrderDetailService
{
    private $orderDetailRepository;

    public function __construct(OrderDetailRepository $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function data($orderId)
    {
        $orderDetails = $this->orderDetailRepository->getOrderDetailsByOrderId($orderId);

        return $orderDetails;
    }
}
