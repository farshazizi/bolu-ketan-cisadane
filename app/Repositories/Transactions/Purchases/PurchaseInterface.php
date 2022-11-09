<?php

namespace App\Repositories\Transactions\Purchases;

interface PurchaseInterface
{
    public function getPurchases();
    public function storePurchase($data);
    public function getPurchaseById($id);
    public function destoryPurchaseById($id);
    public function getGrandTotalDailyPurchase();
    public function getPurchasesByDate($date);
    public function getTotalPurchasesByDate($date);
    public function getPurchasesByMonth($month);
    public function getTotalPurchasesByMonth($month);
}