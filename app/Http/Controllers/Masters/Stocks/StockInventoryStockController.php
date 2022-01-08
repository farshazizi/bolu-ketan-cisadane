<?php

namespace App\Http\Controllers\Masters\Stocks;

use App\Http\Controllers\Controller;
use App\Services\Masters\InventoryStocks\InventoryStockService;

class StockInventoryStockController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
