<?php

namespace App\Repositories\Transactions\Orders;

interface OrderAdditionalDetailInterface
{
    public function getOrderAdditionalDetails($orderDetailId);
}