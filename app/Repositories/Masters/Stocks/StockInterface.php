<?php

namespace App\Repositories\Masters\Stocks;

interface StockInterface
{
    public function getStocks();
    public function storeStock($data);
    public function getStockById($id);
    public function destoryStockById($id);
}