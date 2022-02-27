<?php

namespace App\Repositories\Transactions\Sales;

interface SaleInterface
{
    public function getSales();
    public function storeSale($data);
    public function getSaleById($id);
    public function destorySaleById($id);
    public function getStockByInventoryStockId($id);
}