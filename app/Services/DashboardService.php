<?php

namespace App\Services;

use App\Services\Masters\Stocks\StockService;
use App\Services\Transactions\Orders\OrderService;
use App\Services\Transactions\Purchases\PurchaseService;
use App\Services\Transactions\Sales\SaleService;

class DashboardService
{
    private $purchaseService;
    private $saleService;
    private $stockService;
    private $orderService;

    public function __construct(
        PurchaseService $purchaseService,
        SaleService $saleService,
        StockService $stockService,
        OrderService $orderService
    ) {
        $this->purchaseService = $purchaseService;
        $this->saleService = $saleService;
        $this->stockService = $stockService;
        $this->orderService = $orderService;
    }

    public function calculateDailyBalance()
    {
        $dailyPurchaseBalance = $this->purchaseService->getGrandTotalDailyPurchase();
        $dailySaleBalance = $this->saleService->getGrandTotalDailySale();

        $dailyBalance = $dailySaleBalance - $dailyPurchaseBalance;

        return $dailyBalance;
    }

    public function getDashboardData()
    {
        $grandTotalPurchase = $this->purchaseService->getGrandTotalDailyPurchase();
        $grandTotalSale = $this->saleService->getGrandTotalDailySale();

        return [
            'dailyBalance' => $grandTotalSale - $grandTotalPurchase,
            'grandTotalPurchase' => $grandTotalPurchase,
            'grandTotalSale' => $grandTotalSale,
            'stocks' => $this->stockService->getStocks(),
        ];
    }

    public function getOrdersWaitingData()
    {
        return $this->orderService->dataOrdersWaiting();
    }
}
