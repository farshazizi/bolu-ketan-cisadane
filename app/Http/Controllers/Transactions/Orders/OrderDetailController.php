<?php

namespace App\Http\Controllers\Transactions\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Orders\DataOrderDetailRequest;
use App\Services\Transactions\Orders\OrderDetailService;

class OrderDetailController extends Controller
{
    private $orderDetailService;

    public function __construct(OrderDetailService $orderDetailService)
    {
        $this->orderDetailService = $orderDetailService;
    }

    public function data(DataOrderDetailRequest $dataOrderDetailRequest)
    {
        $request = $dataOrderDetailRequest->validated();

        $orderDetails = $this->orderDetailService->data($request);
        if ($orderDetails) {
            return response()->json([
                'status' => 'success',
                'message' => 'Get order details success',
                'data' => $orderDetails,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order details empty',
            'data' => [],
        ]);
    }
}
