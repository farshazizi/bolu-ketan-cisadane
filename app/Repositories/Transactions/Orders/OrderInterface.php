<?php

namespace App\Repositories\Transactions\Orders;

interface OrderInterface
{
    public function getOrders();
    public function storeOrder($data);
    public function getOrderById($id);
    public function destoryOrderById($id);
    public function getStockByInventoryStockId($id);
    public function getGrandTotalDailyOrder();
    public function getOrdersWaiting();
}