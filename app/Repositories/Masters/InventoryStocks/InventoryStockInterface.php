<?php

namespace App\Repositories\Masters\InventoryStocks;

interface InventoryStockInterface
{
    public function getInventoryStocks();
    public function storeInventoryStock($data);
    public function getInventoryStockById($id);
    public function updateInventoryStockById($data, $id);
    public function destroyInventoryStockById($id);
    public function getPriceById($id);
}