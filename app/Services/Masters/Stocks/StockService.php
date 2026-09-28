<?php

namespace App\Services\Masters\Stocks;

use App\Models\Masters\Stocks\Stock;
use App\Repositories\Masters\InventoryStocks\InventoryStockRepository;
use App\Repositories\Masters\Stocks\StockRepository;
use App\Repositories\Transactions\Sales\SaleRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class StockService
{
    private $inventoryStockRepository;
    private $saleRepository;
    private $stockRepository;

    public function __construct(InventoryStockRepository $inventoryStockRepository, SaleRepository $saleRepository, StockRepository $stockRepository)
    {
        $this->inventoryStockRepository = $inventoryStockRepository;
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
            $stockIn = $this->stockRepository->getStockInByInventoryStockId($id);
            $stockOut = $this->stockRepository->getStockOutByInventoryStockId($id);
            $stockSale = $this->saleRepository->getStockByInventoryStockId($id);

            return $stockIn - $stockOut - $stockSale;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Gagal mendapatkan stock.');
        }
    }

    public function getStocks()
    {
        $stocks = $this->inventoryStockRepository->getInventoryStocks()->get(['id', 'name', 'icon']);

        // One grouped query per source instead of three queries per inventory stock
        $stockIn = $this->stockRepository->getStockInQuantities();
        $stockOut = $this->stockRepository->getStockOutQuantities();
        $stockSale = $this->saleRepository->getSoldQuantities();

        $dataStocks = [];
        foreach ($stocks as $key => $stock) {
            $dataStocks[$key]['name'] = $stock->name;
            $dataStocks[$key]['stock'] = $stockIn->get($stock->id, 0) - $stockOut->get($stock->id, 0) - $stockSale->get($stock->id, 0);
            $dataStocks[$key]['icon'] = $stock->icon;
        }

        return $dataStocks;
    }
}
