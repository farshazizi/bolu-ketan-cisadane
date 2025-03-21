<?php

namespace App\Repositories\Transactions\Sales;

interface SaleInterface
{
    public function getSales();
    public function storeSale($data, $invoiceNumber);
    public function getSaleById($id);
    public function destorySaleById($id);
    public function getStockByInventoryStockId($id);
    public function getGrandTotalDailySale();
    public function getLastInvoiceNumberSaleByDate($date);
    public function getSalesByDate($date);
    public function getTotalSalesByDate($date);
    public function getSalesByMonth($month);
    public function getTotalSalesByMonth($month);
}