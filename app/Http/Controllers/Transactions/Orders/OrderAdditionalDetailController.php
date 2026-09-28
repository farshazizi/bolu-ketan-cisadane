<?php

namespace App\Http\Controllers\Transactions\Orders;

use App\Http\Controllers\Controller;
use App\Services\Transactions\Orders\OrderAdditionalDetailService;

class OrderAdditionalDetailController extends Controller
{
    private $orderAdditionalDetailService;

    public function __construct(OrderAdditionalDetailService $orderAdditionalDetailService)
    {
        $this->orderAdditionalDetailService = $orderAdditionalDetailService;
    }

    public function data($orderDetailId)
    {
        $orderAdditionalDetails = $this->orderAdditionalDetailService->data($orderDetailId);

        return response()->json([
            'status' => 'success',
            'code' => 'get-order-additional-details-success',
            'message' => 'Berhasil mengambil data tambahan pesanan.',
            'data' => [
                'orderAdditionalDetails' => $orderAdditionalDetails
            ]
        ]);
    }
}
