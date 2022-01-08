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
        return view('contents.masters.stocks.stock-out.create', compact('inventoryStocks'));
    }

    public function store(StoreStockOutRequest $storeStockOutRequest)
    {
        try {
            $request = $storeStockOutRequest->safe()->collect();

            $inventoryStock = $this->stockService->store($request);

            if ($inventoryStock) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Stok keluar berhasil ditambahkan.'
                ]);
            }

            return back()->with([
                'status' => 'danger',
                'message' => 'Stok keluar gagal ditambahkan.'
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'danger',
                'message' => 'Stok keluar gagal ditambahkan.'
            ]);
        }
    }
}
