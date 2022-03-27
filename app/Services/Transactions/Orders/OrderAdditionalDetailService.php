<?php

namespace App\Services\Transactions\Orders;

use App\Repositories\Transactions\Orders\OrderAdditionalDetailRepository;

class OrderAdditionalDetailService
{
    private $orderAdditionalDetailRepository;

    public function __construct(OrderAdditionalDetailRepository $orderAdditionalDetailRepository)
    {
        $this->orderAdditionalDetailRepository = $orderAdditionalDetailRepository;
    }

    public function data($orderDetailId)
    {
        $orderAdditionalDetails = $this->orderAdditionalDetailRepository->getOrderAdditionalDetails($orderDetailId);

        if ($orderAdditionalDetails) {
            foreach ($orderAdditionalDetails as $orderAdditionalDetail) {
                $orderAdditionalDetail->price = number_format($orderAdditionalDetail->price, 0);
            }
        }

        return $orderAdditionalDetails;
    }
}