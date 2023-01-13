<?php

namespace App\Repositories\Transactions\Sales;

interface SaleAdditionalDetailInterface
{
    public function getSaleAdditionalDetails($saleDetailId);
    public function storeSaleAdditionalDetail($data, $saleDetail);
    public function destorySaleAdditionalDetailsBySaleId($saleId);
}
