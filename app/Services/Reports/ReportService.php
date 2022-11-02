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

        $groupingSales = [];
        $sumGrandTotalSale = 0;
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

            $sumGrandTotalSale += $grandTotal;

            foreach ($inventoryStocks as $keyInventoryStock => $inventoryStock) {
                // Set initial value
                $totalQuantity = 0;

                // Mapping key object
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['id'] = $inventoryStock->id;
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['name'] = $inventoryStock->name;
                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['quantity'] = 0;

                foreach ($sale->saleDetails as $saleDetail) {
                    // Set variable
                    $inventoryStockId = $saleDetail->inventory_stock_id;
                    $quantity = $saleDetail->quantity;

                    if ($groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['id'] == $inventoryStockId) {
                        $totalQuantity += $quantity;
                        $totalItemInventorySale += $quantity;
                    }
                }

                $groupingSales[$keySale]['saleDetails'][$keyInventoryStock]['quantity'] = $totalQuantity;
            }
        }

        // Get total sale
        $totalSale = $this->saleRepository->getTotalSaleByDate($dailyReportDate);

        $dataTotalSale = [];
        foreach ($inventoryStocks as $keyInventoryStock => $inventoryStock) {
            $dataTotalSale[$keyInventoryStock]['id'] = $inventoryStock->id;
            $dataTotalSale[$keyInventoryStock]['name'] = $inventoryStock->name;
            $dataTotalSale[$keyInventoryStock]['quantity'] = 0;

            foreach ($totalSale as $sale) {
                // Set variable
                $inventoryStockId = $sale->id;

                if ($dataTotalSale[$keyInventoryStock]['id'] === $inventoryStockId) {
                    $dataTotalSale[$keyInventoryStock]['quantity'] = $sale->quantity;
                }
            }
        }

        // Get ingredients
        $ingredients = $this->ingredientRepository->getIngredients();
        $ingredients = $ingredients->orderBy('name')->get();

        // Get data purchases
        $purchases = $this->purchaseRepository->getPurchasesByDate($dailyReportDate);

        $groupingPurchases = [];
        $sumGrandTotalPurchase = 0;
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

            $sumGrandTotalPurchase += $grandTotal;

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

        // Get total purchase
        $totalPurchase = $this->purchaseRepository->getTotalPurchaseByDate($dailyReportDate);

        $dataTotalPurchase = [];
        foreach ($ingredients as $keyIngredient => $ingredient) {
            $dataTotalPurchase[$keyIngredient]['id'] = $ingredient->id;
            $dataTotalPurchase[$keyIngredient]['name'] = $ingredient->name;
            $dataTotalPurchase[$keyIngredient]['quantity'] = 0;

            foreach ($totalPurchase as $purchase) {
                // Set variable
                $ingredientId = $purchase->id;

                if ($dataTotalPurchase[$keyIngredient]['id'] === $ingredientId) {
                    $dataTotalPurchase[$keyIngredient]['quantity'] = $purchase->quantity;
                }
            }
        }

        $data = [
            'inventoryStocks' => $inventoryStocks,
            'sales' => $groupingSales,
            'totalSale' => $dataTotalSale,
            'sumGrandTotalSale' => $sumGrandTotalSale,
            'ingredients' => $ingredients,
            'purchases' => $groupingPurchases,
            'totalPurchase' => $dataTotalPurchase,
            'sumGrandTotalPurchase' => $sumGrandTotalPurchase
        ];

        return $data;
    }
}
