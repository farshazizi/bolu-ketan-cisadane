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
            'status' => 'success',
            'code' => 'get-sale-additional-details-success',
            'message' => 'Berhasil mengambil data tambahan penjualan.',
            'data' => [
                'saleAdditionalDetails' => $saleAdditionalDetails
            ]
        ]);
    }
}
