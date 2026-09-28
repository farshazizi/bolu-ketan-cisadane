<?php

namespace App\Services\Reports;

use App\Models\Masters\Ingredients\Ingredient;
use App\Models\Masters\InventoryStocks\InventoryStock;
use App\Repositories\Transactions\Purchases\PurchaseRepository;
use App\Repositories\Transactions\Sales\SaleRepository;
use Carbon\Carbon;

class SalesPurchasesReportService
{
    private $purchaseRepository;
    private $reportTableBuilder;
    private $saleRepository;

    public function __construct(PurchaseRepository $purchaseRepository, ReportTableBuilder $reportTableBuilder, SaleRepository $saleRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->reportTableBuilder = $reportTableBuilder;
        $this->saleRepository = $saleRepository;
    }

    public function dailyReport($date)
    {
        $sales = $this->saleRepository->getSalesByDate($date);
        $purchases = $this->purchaseRepository->getPurchasesByDate($date);

        return $this->buildReport($sales, $purchases);
    }

    public function monthlyReport($month)
    {
        $sales = $this->saleRepository->getSalesByMonth($month);
        $purchases = $this->purchaseRepository->getPurchasesByMonth($month);

        return $this->buildReport($sales, $purchases);
    }

    private function buildReport($sales, $purchases)
    {
        $inventoryStocks = InventoryStock::orderBy('name')->get(['id', 'name']);
        $ingredients = Ingredient::orderBy('name')->get(['id', 'name']);

        $saleRows = $sales->map(function ($sale) use ($inventoryStocks) {
            return $this->transactionRow($sale) + [
                'saleDetails' => $this->reportTableBuilder->quantitiesPerItem($inventoryStocks, $sale->saleDetails, 'inventory_stock_id'),
                'totalAdditional' => $sale->saleDetails->sum('total_additional'),
            ];
        })->all();

        $purchaseRows = $purchases->map(function ($purchase) use ($ingredients) {
            return $this->transactionRow($purchase) + [
                'purchaseDetails' => $this->reportTableBuilder->quantitiesPerItem($ingredients, $purchase->purchaseDetails, 'ingredient_id'),
            ];
        })->all();

        return [
            'inventoryStocks' => $inventoryStocks,
            'sales' => $saleRows,
            'sumTotalAdditionalSales' => array_sum(array_column($saleRows, 'totalAdditional')),
            'totalSales' => $this->reportTableBuilder->totalPerItem($inventoryStocks, $saleRows, 'saleDetails'),
            'sumGrandTotalSales' => $sales->sum('grand_total'),
            'ingredients' => $ingredients,
            'purchases' => $purchaseRows,
            'totalPurchases' => $this->reportTableBuilder->totalPerItem($ingredients, $purchaseRows, 'purchaseDetails'),
            'sumGrandTotalPurchases' => $purchases->sum('grand_total'),
        ];
    }

    private function transactionRow($transaction)
    {
        return [
            'id' => $transaction->id,
            'date' => Carbon::parse($transaction->date)->format('d-m-Y'),
            'grandTotal' => $transaction->grand_total,
            'createdAt' => Carbon::parse($transaction->created_at)->format('H:i'),
        ];
    }
}
