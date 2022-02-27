<?php

namespace App\Repositories\Transactions\Sales;

use App\Models\Transactions\Sales\SaleAdditionalDetail;

class SaleAdditionalDetailRepository implements SaleAdditionalDetailInterface
{
    public function getSaleAdditionalDetails($saleDetailId)
    {
        $saleAdditionalDetails = SaleAdditionalDetail::with('additional')
            ->where('sale_detail_id', $saleDetailId)
            ->get();

        return $saleAdditionalDetails;
    }
}
