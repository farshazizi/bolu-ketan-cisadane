<?php

namespace App\Repositories\Transactions\Sales;

interface SaleDetailInterface
{
    public function storeSaleDetail($data, $saleId);
}
