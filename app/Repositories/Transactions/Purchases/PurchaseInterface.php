<?php

namespace App\Repositories\Transactions\Purchases;

interface PurchaseInterface
{
    public function getPurchases();
    public function storePurchase($data);
    public function getPurchaseById($id);
    public function destoryPurchaseById($id);
    public function getGrandTotalDailyPurchase();
}