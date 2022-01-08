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
            $request = $storeStockInRequest->safe()->collect();

            $stockIn = $this->stockService->store($request);

            if ($stockIn) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Stok masuk berhasil ditambahkan.'
                ]);
            }

            return back()->with([
                'status' => 'danger',
                'message' => 'Stok masuk gagal ditambahkan.'
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'danger',
                'message' => 'Stok masuk gagal ditambahkan.'
            ]);
        }
    }
}
