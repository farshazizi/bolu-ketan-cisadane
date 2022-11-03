<?php

namespace App\Http\Controllers\Masters\Stocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Stocks\StoreStockOutRequest;
use App\Services\Masters\InventoryStocks\InventoryStockService;
use App\Services\Masters\Stocks\StockService;
use Exception;
use Illuminate\Support\Facades\Log;

class StockOutController extends Controller
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
        $inventoryStocks = $$inventoryStocks->get();

        return view('contents.masters.stocks.stock-out.create', compact('inventoryStocks'));
    }

    public function store(StoreStockOutRequest $storeStockOutRequest)
    {
        try {
            $request = $storeStockOutRequest->validated();

            $stockOut = $this->stockService->store($request);

            if ($stockOut) {
                return response()->json([
                    'status' => 'success',
                    'code' => 'store-stock-out-success',
                    'message' => 'Stok keluar berhasil ditambahkan.',
                    'data' => [
                        'stockOut' => $stockOut
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'code' => 'store-stock-out-failed',
                'message' => 'Stok keluar gagal ditambahkan.',
                'data' => []
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'code' => 'store-stock-out-failed',
                'message' => 'Stok keluar gagal ditambahkan.',
                'data' => []
            ], 500);
        }
    }
}
