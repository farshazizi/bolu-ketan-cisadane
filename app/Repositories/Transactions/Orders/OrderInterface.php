<?php

namespace App\Repositories\Transactions\Orders;

interface OrderInterface
{
    public function getOrders();
    public function storeOrder($data);
    public function getOrderById($id);
    public function updateOrder($data, $id);
    public function destoryOrderById($id);
    public function getStockByInventoryStockId($id);
    public function getGrandTotalDailyOrder();
    public function getOrdersWaiting();
    public function getOrdersByDateAndStatus($date, $status);
    public function getTotalOrdersByDate($date);
    public function setOrderStatusSuccessById($orderId);
    public function setOrderStatusFailedById($id);
}
