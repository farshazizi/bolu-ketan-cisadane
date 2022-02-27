<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Services\Masters\InventoryStocks\InventoryStockService;
use Exception;
use Illuminate\Support\Facades\Log;

class SalePriceController extends Controller
{
    private $inventoryStockService;

    public function __construct(InventoryStockService $inventoryStockService)
    {
        $this->inventoryStockService = $inventoryStockService;
    }

    public function __invoke($id)
    {
        try {
            $price = $this->inventoryStockService->getPriceById($id);

            if ($price) {
                return response()->json([
                    'status' => 'success',
                    'code' => 'get-price-success',
                    'message' => 'Get price success.',
                    'data' => [
                        'price' => $price->price
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'code' => 'get-price-failed',
                'message' => 'Get price failed.',
                'data' => []
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'code' => 'get-price-failed',
                'message' => 'Get price success.',
                'data' => []
            ], 500);
        }
    }
}
