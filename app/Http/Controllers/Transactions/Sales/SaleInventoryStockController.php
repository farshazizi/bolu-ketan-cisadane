<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Services\Masters\InventoryStocks\InventoryStockService;

class SaleInventoryStockController extends Controller
{
    public function __invoke(InventoryStockService $inventoryStockService)
    {
        $inventoryStocks = $inventoryStockService->data();

        return response()->json([
            'status' => 'success',
            'message' => 'Get inventory stocks success.',
            'data' => [
                'inventoryStocks' => $inventoryStocks
            ]
        ], 200);
    }
}
