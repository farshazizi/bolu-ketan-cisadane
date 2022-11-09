<?php

namespace App\Services\Reports;

use App\Repositories\Masters\Ingredients\IngredientRepository;
use App\Repositories\Masters\InventoryStocks\InventoryStockRepository;
use App\Repositories\Transactions\Purchases\PurchaseRepository;
use App\Repositories\Transactions\Sales\SaleRepository;
use Carbon\Carbon;

class MonthlyReportService
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

    public function monthlyReport($monthlyReportDate)
    {
        // Set initial value
        $data = [];

        // Set variable
        $month = Carbon::parse($monthlyReportDate)->format('m');

        // Get inventory stocks
        $inventoryStocks = $this->inventoryStockRepository->getInventoryStocks();
        $inventoryStocks = $inventoryStocks->orderBy('name')->get();

        // Get data sales
        $sales = $this->saleRepository->getSalesByMonth($month);

        // Grouping sales
        $dataGroupingSales = $this->groupingSales($inventoryStocks, $sales);
        $groupingSales = $dataGroupingSales['groupingSales'];
        $sumGrandTotalSales = $dataGroupingSales['sumGrandTotalSales'];

        // Calculate total additional sales
        $sumTotalAdditionalSales = $this->calculateTotalAdditionalSales($groupingSales);

        // Get total sales
        $totalSales = $this->saleRepository->getTotalSalesByMonth($month);

        // Calculate total sales
        $dataTotalSales = $this->calculateTotalSales($inventoryStocks, $totalSales);

        // Get ingredients
        $ingredients = $this->ingredientRepository->getIngredients();
        $ingredients = $ingredients->orderBy('name')->get();

        // Get data purchases
        $purchases = $this->purchaseRepository->getPurchasesByMonth($month);

        // Grouping purchases
        $dataGroupingPurchases = $this->groupingPurchases($ingredients, $purchases);
        $groupingPurchases = $dataGroupingPurchases['groupingPurchases'];
        $sumGrandTotalPurchases = $dataGroupingPurchases['sumGrandTotalPurchases'];

        // Get total purchases
        $totalPurchases = $this->purchaseRepository->getTotalPurchasesByMonth($month);

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

                // Set variable
                $inventoryStockId = $inventoryStock->id;
                $name = $inventoryStock->name;

                // Mapping key object
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['id'] = $inventoryStockId;
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['name'] = $name;
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
            // Set variable
            $inventoryStockId = $inventoryStock->id;
            $name = $inventoryStock->name;

            $dataTotalSales[$keyInventoryStock]['id'] = $inventoryStockId;
            $dataTotalSales[$keyInventoryStock]['name'] = $name;
            $dataTotalSales[$keyInventoryStock]['quantity'] = 0;

            foreach ($totalSales as $totalSale) {
                // Set variable
                $inventoryStockId = $totalSale->id;
                $quantity = $totalSale->quantity;

                if ($dataTotalSales[$keyInventoryStock]['id'] === $inventoryStockId) {
                    $dataTotalSales[$keyInventoryStock]['quantity'] = $quantity;
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

                // Set variable
                $ingredientId = $ingredient->id;
                $name = $ingredient->name;

                // Mapping key object
                $groupingPurchases[$keyPurchase]['purchaseDetails'][$keyIngredient]['id'] = $ingredientId;
                $groupingPurchases[$keyPurchase]['purchaseDetails'][$keyIngredient]['name'] = $name;
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
            // Set variable
            $ingredientId = $ingredient->id;
            $name = $ingredient->name;

            $dataTotalPurchases[$keyIngredient]['id'] = $ingredientId;
            $dataTotalPurchases[$keyIngredient]['name'] = $name;
            $dataTotalPurchases[$keyIngredient]['quantity'] = 0;

            foreach ($totalPurchases as $totalPurchase) {
                // Set variable
                $ingredientId = $totalPurchase->id;
                $quantity = $totalPurchase->quantity;

                if ($dataTotalPurchases[$keyIngredient]['id'] === $ingredientId) {
                    $dataTotalPurchases[$keyIngredient]['quantity'] = $quantity;
                }
            }
        }

        return $dataTotalPurchases;
    }
}
