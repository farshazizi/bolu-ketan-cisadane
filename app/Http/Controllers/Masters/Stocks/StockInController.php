<?php

namespace App\Http\Controllers\Masters\Stocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Stocks\StoreStockInRequest;
use App\Services\Masters\InventoryStocks\InventoryStockService;
use App\Services\Masters\Stocks\StockService;
use Exception;
use Illuminate\Support\Facades\Log;

class StockInController extends Controller
{
    private $inventoryStockService;
    private $stockService;

    public function __construct(InventoryStockService $inventoryStockService, StockService $stockService)
    {
        $this->inventoryStockService = $inventoryStockService;
        $this->stockService = $stockService;
    }

    public function create()
    {
        $inventoryStocks = $this->inventoryStockService->data();

        return view('contents.masters.stocks.stock-in.create', compact('inventoryStocks'));
    }

    public function store(StoreStockInRequest $storeStockInRequest)
    {
        try {
            $request = $storeStockInRequest->validated();

            $stockIn = $this->stockService->store($request);

            if ($stockIn) {
                return response()->json([
                    'status' => 'success',
                    'code' => 'store-stock-in-success',
                    'message' => 'Stok masuk berhasil ditambahkan.',
                    'data' => [
                        'stockIn' => $stockIn
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'code' => 'store-stock-in-failed',
                'message' => 'Stok masuk gagal ditambahkan.',
                'data' => []
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'code' => 'store-stock-in-failed',
                'message' => 'Stok masuk gagal ditambahkan.',
                'data' => []
            ], 500);
        }
    }
}
