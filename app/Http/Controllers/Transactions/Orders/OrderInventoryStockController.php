<?php

namespace App\Http\Controllers\Transactions\Orders;

use App\Http\Controllers\Controller;
use App\Services\Masters\InventoryStocks\InventoryStockService;

class OrderInventoryStockController extends Controller
{
    private $inventoryStockService;

    public function __construct(InventoryStockService $inventoryStockService)
    {
        $this->inventoryStockService = $inventoryStockService;
    }

    public function __invoke()
    {
        $inventoryStocks = $this->inventoryStockService->data();
        $inventoryStocks = $inventoryStocks->get();

        return response()->json([
            'status' => 'success',
            'code' => 'get-inventory-stocks-success',
            'message' => 'Get inventory stocks success.',
            'data' => [
                'inventoryStocks' => $inventoryStocks
            ]
        ], 200);
    }
}
