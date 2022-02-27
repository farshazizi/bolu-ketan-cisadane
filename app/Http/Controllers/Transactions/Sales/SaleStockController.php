<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Services\Masters\Stocks\StockService;
use Exception;
use Illuminate\Support\Facades\Log;

class SaleStockController extends Controller
{
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function __invoke($id)
    {
        try {
            $stock = $this->stockService->getStockByInventoryStockId($id);

            return response()->json([
                'status' => 'success',
                'code' => 'get-stock-success',
                'message' => 'Get stock success.',
                'data' => [
                    'stock' => $stock
                ]
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'code' => 'get-stock-failed',
                'message' => $exception->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
