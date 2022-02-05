<?php

namespace App\Services\Masters\InventoryStocks;

use App\Repositories\Masters\InventoryStocks\InventoryStockRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class InventoryStockService
{
    private $inventoryStockRepository;

    public function __construct(InventoryStockRepository $inventoryStockRepository)
    {
        $this->inventoryStockRepository = $inventoryStockRepository;
    }

    public function data()
    {
        $inventoryStocks = $this->inventoryStockRepository->getInventoryStocks();

        return $inventoryStocks;
    }

    public function storeInventoryStock($data)
    {
        try {
            $inventoryStock = $this->inventoryStockRepository->storeInventoryStock($data);

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal ditambahkan.');
        }
    }

    public function getInventoryStockById($id)
    {
        $inventoryStock = $this->inventoryStockRepository->getInventoryStockById($id);

        return $inventoryStock;
    }

    public function updateInventoryStockById($data, $id)
    {
        try {
            $inventoryStock = $this->updateInventoryStockById($data, $id);

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal diperbaharui.');
        }
    }

    public function destroyInventoryStockById($id)
    {
        try {
            $inventoryStock = $this->destroyInventoryStockById($id);

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal dihapus.');
        }
    }

    public function getPriceById($id)
    {
        $price = $this->inventoryStockRepository->getPriceById($id);

        return $price;
    }
}
