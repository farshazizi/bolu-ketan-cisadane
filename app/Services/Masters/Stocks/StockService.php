<?php

namespace App\Services\Masters\Stocks;

use App\Models\Masters\Stocks\Stock;
use App\Repositories\Masters\Stocks\StockRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class StockService
{
    private $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function data()
    {
        $stocks = $this->stockRepository->getStocks();

        return $stocks;
    }

    public function store($data)
    {
        try {
            $stock = $this->stockRepository->storeStock($data);

            return $stock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok masuk gagal ditambahkan.');
        }
    }

    public function getStockById($id)
    {
        $stock = Stock::has('stockDetails')->with('stockDetails.inventoryStock')->findOrFail($id);

        return $stock;
    }

    public function destroy($id)
    {
        try {
            $stock = $this->stockRepository->destoryStockById($id);

            return $stock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal dihapus.');
        }
    }
}
