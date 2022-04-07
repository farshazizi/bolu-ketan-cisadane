<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\Masters\Stocks\StockService;
use App\Services\Transactions\Purchases\PurchaseService;
use App\Services\Transactions\Sales\SaleService;

class DashboardController extends Controller
{
    private $dashboardService;
    private $purchaseService;
    private $saleService;
    private $stockService;

    public function __construct(DashboardService $dashboardService, PurchaseService $purchaseService, SaleService $saleService, StockService $stockService)
    {
        $this->dashboardService = $dashboardService;
        $this->purchaseService = $purchaseService;
        $this->saleService = $saleService;
        $this->stockService = $stockService;
    }

    public function index()
    {
        // Daily purchases
        $grandTotalPurchase = $this->purchaseService->getGrandTotalDailyPurchase();
        $grandTotalPurchase = number_format($grandTotalPurchase, 0);

        // Daily sales
        $grandTotalSale = $this->saleService->getGrandTotalDailySale();
        $grandTotalSale = number_format($grandTotalSale, 0);

        // Stock
        $stocks = $this->stockService->getStocks();

        // Daily balance
        $dailyBalance = $this->dashboardService->calculateDailyBalance();
        $dailyBalance = number_format($dailyBalance, 0);

        return view('layouts.dashboard', compact('dailyBalance', 'grandTotalPurchase', 'grandTotalSale', 'stocks'));
    }
}
