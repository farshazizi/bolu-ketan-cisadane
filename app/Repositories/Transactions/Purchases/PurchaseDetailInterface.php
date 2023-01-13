<?php

namespace App\Repositories\Transactions\Purchases;

interface PurchaseDetailInterface
{
    public function storePurchaseDetail($data, $purchaseId);
    public function destoryPurchaseDetailsByPurchaseId($purchaseId);
}
