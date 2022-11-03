<?php

namespace App\Services\Reports;

use App\Repositories\Masters\Ingredients\IngredientRepository;
use App\Repositories\Masters\InventoryStocks\InventoryStockRepository;
use App\Repositories\Transactions\Purchases\PurchaseRepository;
use App\Repositories\Transactions\Sales\SaleRepository;
use Carbon\Carbon;

class ReportService
{
    private $ingredientRepository;
    private $inventoryStockRepository;
    private $purchaseRepository;
    private $saleRepository;

    public function __construct(IngredientRepository $ingredientRepository, InventoryStockRepository $inventoryStockRepository, PurchaseRepository $purchaseRepository, SaleRepository $saleRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
        $this->inventoryStockRepository = $inventoryStockRepository;
        $this->purchaseRepository = $purchaseRepository;
        $this->saleRepository = $saleRepository;
    }

    public function dailyReport($dailyReportDate)
    {
        // Set initial value
        $data = [];

        // Get inventory stocks
        $inventoryStocks = $this->inventoryStockRepository->getInventoryStocks();
        $inventoryStocks = $inventoryStocks->orderBy('name')->get();

        // Get data sales
        $sales = $this->saleRepository->getSalesByDate($dailyReportDate);

        // Grouping sales
        $dataGroupingSales = $this->groupingSales($inventoryStocks, $sales);
        $groupingSales = $dataGroupingSales['groupingSales'];
        $sumGrandTotalSales = $dataGroupingSales['sumGrandTotalSales'];

        // Calculate total additional sales
        $sumTotalAdditionalSales = $this->calculateTotalAdditionalSales($groupingSales);

        // Get total sales
        $totalSales = $this->saleRepository->getTotalSalesByDate($dailyReportDate);

        // Calculate total sales
        $dataTotalSales = $this->calculateTotalSales($inventoryStocks, $totalSales);

        // Get ingredients
        $ingredients = $this->ingredientRepository->getIngredients();
        $ingredients = $ingredients->orderBy('name')->get();

        // Get data purchases
        $purchases = $this->purchaseRepository->getPurchasesByDate($dailyReportDate);

        // Grouping purchases
        $dataGroupingPurchases = $this->groupingPurchases($ingredients, $purchases);
        $groupingPurchases = $dataGroupingPurchases['groupingPurchases'];
        $sumGrandTotalPurchases = $dataGroupingPurchases['sumGrandTotalPurchases'];

        // Get total purchases
        $totalPurchases = $this->purchaseRepository->getTotalPurchasesByDate($dailyReportDate);

        // Calculate total purchase
        $dataTotalPurchases = $this->calculateTotalPurchases($ingredients, $totalPurchases);

        $data = [
            'inventoryStocks' => $inventoryStocks,
            'sales' => $groupingSales,
            'sumTotalAdditionalSales' => $sumTotalAdditionalSales,
            'totalSales' => $dataTotalSales,
            'sumGrandTotalSales' => $sumGrandTotalSales,
            'ingredients' => $ingredients,
            'purchases' => $groupingPurchases,
            'totalPurchases' => $dataTotalPurchases,
            'sumGrandTotalPurchases' => $sumGrandTotalPurchases
        ];

        return $data;
    }

    public function groupingSales($inventoryStocks, $sales)
    {
        // Set initial value
        $data = [];
        $groupingSales = [];
        $sumGrandTotalSales = 0;

        foreach ($sales as $keySale => $sale) {
            $totalItemInventorySale = 0;

            // Set variable
            $saleId = $sale->id;
            $date = Carbon::parse($sale->date)->format('d-m-Y');
            $grandTotal = $sale->grand_total;
            $createdAt = Carbon::parse($sale->created_at)->format('H:i');

            // Mapping key object
            $groupingSales[$keySale]['id'] = $saleId;
            $groupingSales[$keySale]['date'] = $date;
            $groupingSales[$keySale]['grandTotal'] = $grandTotal;
            $groupingSales[$keySale]['createdAt'] = $createdAt;

            $sumGrandTotalSales += $grandTotal;

            foreach ($inventoryStocks as $keyInventoryStock => $inventoryStock) {
                // Set initial value
                $totalQuantity = 0;
                $sumTotalAdditionalSales = 0;

                // Mapping key object
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['id'] = $inventoryStock->id;
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['name'] = $inventoryStock->name;
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['quantity'] = 0;

                foreach ($sale->saleDetails as $saleDetail) {
                    // Set variable
                    $inventoryStockId = $saleDetail->inventory_stock_id;
                    $quantity = $saleDetail->quantity;
                    $totalAdditional = $saleDetail->total_additional;

                    // Get total additional
                    $sumTotalAdditionalSales += $totalAdditional;

                    if ($groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['id'] == $inventoryStockId) {
                        $totalQuantity += $quantity;
                        $totalItemInventorySale += $quantity;
                    }
                }

                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['quantity'] = $totalQuantity;
            }

            $groupingSales[$keySale]['totalAdditional'] = $sumTotalAdditionalSales;
        }

        $data = [
            'groupingSales' => $groupingSales,
            'sumGrandTotalSales' => $sumGrandTotalSales
        ];

        return $data;
    }

    public function calculateTotalAdditionalSales($groupingSales)
    {
        // Set initial value
        $sumTotalAdditionalSales = 0;

        foreach ($groupingSales as $groupingSale) {
            $totalAdditional = $groupingSale['totalAdditional'];

            $sumTotalAdditionalSales += $totalAdditional;
        }

        return $sumTotalAdditionalSales;
    }

    public function calculateTotalSales($inventoryStocks, $totalSales)
    {
        // Set initial value
        $dataTotalSales = [];

        foreach ($inventoryStocks as $keyInventoryStock => $inventoryStock) {
            $dataTotalSales[$keyInventoryStock]['id'] = $inventoryStock->id;
            $dataTotalSales[$keyInventoryStock]['name'] = $inventoryStock->name;
            $dataTotalSales[$keyInventoryStock]['quantity'] = 0;

            foreach ($totalSales as $totalSale) {
                // Set variable
                $inventoryStockId = $totalSale->id;

                if ($dataTotalSales[$keyInventoryStock]['id'] === $inventoryStockId) {
                    $dataTotalSales[$keyInventoryStock]['quantity'] = $totalSale->quantity;
                }
            }
        }

        return $dataTotalSales;
    }

    public function groupingPurchases($ingredients, $purchases)
    {
        // Set initial value
        $data = [];
        $groupingPurchases = [];
        $sumGrandTotalPurchases = 0;

        foreach ($purchases as $keyPurchase => $purchase) {
            // Set variable
            $purchaseId = $purchase->id;
            $date = Carbon::parse($purchase->date)->format('d-m-Y');
            $grandTotal = $purchase->grand_total;
            $createdAt = Carbon::parse($purchase->created_at)->format('H:i');

            // Mapping key object
            $groupingPurchases[$keyPurchase]['id'] = $purchaseId;
            $groupingPurchases[$keyPurchase]['date'] = $date;
            $groupingPurchases[$keyPurchase]['grandTotal'] = $grandTotal;
            $groupingPurchases[$keyPurchase]['createdAt'] = $createdAt;

            $sumGrandTotalPurchases += $grandTotal;

            foreach ($ingredients as $keyIngredient => $ingredient) {
                // Set initial value
                $totalQuantity = 0;

                // Mapping key object
                $groupingPurchases[$keyPurchase]['purchaseDetails'][$keyIngredient]['id'] = $ingredient->id;
                $groupingPurchases[$keyPurchase]['purchaseDetails'][$keyIngredient]['name'] = $ingredient->name;
                $groupingPurchases[$keyPurchase]['purchaseDetails'][$keyIngredient]['quantity'] = 0;

                foreach ($purchase->purchaseDetails as $purchaseDetail) {
                    // Set variable
                    $ingredientId = $purchaseDetail->ingredient_id;
                    $quantity = $purchaseDetail->quantity;

                    if ($groupingPurchases[$keyPurchase]['purchaseDetails'][$keyIngredient]['id'] == $ingredientId) {
                        $totalQuantity += $quantity;
                    }
                }

                $groupingPurchases[$keyPurchase]['purchaseDetails'][$keyIngredient]['quantity'] = $totalQuantity;
            }
        }

        $data = [
            'groupingPurchases' => $groupingPurchases,
            'sumGrandTotalPurchases' => $sumGrandTotalPurchases
        ];

        return $data;
    }

    public function calculateTotalPurchases($ingredients, $totalPurchases)
    {
        // Set initial value
        $dataTotalPurchases = [];

        foreach ($ingredients as $keyIngredient => $ingredient) {
            $dataTotalPurchases[$keyIngredient]['id'] = $ingredient->id;
            $dataTotalPurchases[$keyIngredient]['name'] = $ingredient->name;
            $dataTotalPurchases[$keyIngredient]['quantity'] = 0;

            foreach ($totalPurchases as $totalPurchase) {
                // Set variable
                $ingredientId = $totalPurchase->id;

                if ($dataTotalPurchases[$keyIngredient]['id'] === $ingredientId) {
                    $dataTotalPurchases[$keyIngredient]['quantity'] = $totalPurchase->quantity;
                }
            }
        }

        return $dataTotalPurchases;
    }
}
