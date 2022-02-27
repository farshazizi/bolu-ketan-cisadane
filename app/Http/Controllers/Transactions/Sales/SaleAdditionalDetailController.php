<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Services\Transactions\Sales\SaleAdditionalDetailService;

class SaleAdditionalDetailController extends Controller
{
    private $saleAdditionalDetailService;

    public function __construct(SaleAdditionalDetailService $saleAdditionalDetailService)
    {
        $this->saleAdditionalDetailService = $saleAdditionalDetailService;
    }

    public function data($saleDetailId)
    {
        $saleAdditionalDetails = $this->saleAdditionalDetailService->data($saleDetailId);

        return response()->json([
            'message' => 'success',
            'code' => 'get-sale-additional-details-success',
            'message' => 'Get sale additional details success',
            'data' => [
                'saleAdditionalDetails' => $saleAdditionalDetails
            ]
        ]);
    }
}
