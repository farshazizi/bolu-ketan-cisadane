<?php

namespace App\Services;

use App\Services\Transactions\Purchases\PurchaseService;
use App\Services\Transactions\Sales\SaleService;

class DashboardService
{
    private $purchaseService;
    private $saleService;

    public function __construct(PurchaseService $purchaseService, SaleService $saleService)
    {
        $this->purchaseService = $purchaseService;
        $this->saleService = $saleService;
    }

    public function calculateDailyBalance()
    {
        $dailyPurchaseBalance = $this->purchaseService->getGrandTotalDailyPurchase();

        $dailySaleBalance = $this->saleService->getGrandTotalDailySale();

        $dailyBalance = $dailySaleBalance - $dailyPurchaseBalance;

        return $dailyBalance;
    }
}
