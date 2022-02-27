<?php

namespace App\Services\Masters\Stocks;

use App\Models\Masters\Stocks\Stock;
use App\Repositories\Masters\Stocks\StockRepository;
use App\Repositories\Transactions\Sales\SaleRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class StockService
{
    private $saleRepository;
    private $stockRepository;

    public function __construct(SaleRepository $saleRepository, StockRepository $stockRepository)
    {
        $this->saleRepository = $saleRepository;
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

    public function getStockByInventoryStockId($id)
    {
        try {
            $stockExist = 0;

            // Get stock from stock in
            $stockIn = $this->stockRepository->getStockInByInventoryStockId($id);

            if ($stockIn) {
                $stockFromStockIn = 0;
                foreach ($stockIn as $item) {
                    $stockFromStockIn += $item->quantity;
                }
            }

            // Get stock from stock out
            $stockOut = $this->stockRepository->getStockOutByInventoryStockId($id);

            if ($stockOut) {
                $stockFromStockOut = 0;
                foreach ($stockOut as $item) {
                    $stockFromStockOut += $item->quantity;
                }
            }

            // Get stock from sale
            $stockSale = $this->saleRepository->getStockByInventoryStockId($id);

            if ($stockSale) {
                $stockFromSale = 0;
                foreach ($stockSale as $item) {
                    $stockFromSale += $item->quantity;
                }
            }

            // Calculate stock exist
            $stockExist = $stockFromStockIn - $stockFromStockOut - $stockFromSale;

            return $stockExist;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Gagal mendapatkan stock.');
        }
    }
}
