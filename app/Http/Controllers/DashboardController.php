<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\Masters\Stocks\StockService;
use App\Services\Transactions\Orders\OrderService;
use App\Services\Transactions\Purchases\PurchaseService;
use App\Services\Transactions\Sales\SaleService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;
    private $orderService;
    private $purchaseService;
    private $saleService;
    private $stockService;

    public function __construct(DashboardService $dashboardService, OrderService $orderService, PurchaseService $purchaseService, SaleService $saleService, StockService $stockService)
    {
        $this->dashboardService = $dashboardService;
        $this->orderService = $orderService;
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

    public function data()
    {
        $data = $this->orderService->dataOrdersWaiting();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('totalOrder', function ($order) {
                $totalOrder = count($order->orderDetails);

                return $totalOrder;
            })
            ->editColumn('date', function ($order) {
                $date = Carbon::parse($order->date)->locale('id')->translatedFormat('d-M-Y');

                return $date;
            })
            ->addColumn('action', function ($additional) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="#" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-id="' . $additional->id . '"><i class="far fa-eye fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }
}
