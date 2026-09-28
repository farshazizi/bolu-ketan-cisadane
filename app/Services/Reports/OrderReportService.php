<?php

namespace App\Services\Reports;

use App\Models\Masters\InventoryStocks\InventoryStock;
use App\Repositories\Transactions\Orders\OrderRepository;

class OrderReportService
{
    private $orderRepository;
    private $reportTableBuilder;

    public function __construct(OrderRepository $orderRepository, ReportTableBuilder $reportTableBuilder)
    {
        $this->orderRepository = $orderRepository;
        $this->reportTableBuilder = $reportTableBuilder;
    }

    public function orderReport($data)
    {
        $inventoryStocks = InventoryStock::orderBy('name')->get(['id', 'name']);
        $orders = $this->orderRepository->getOrdersByDateAndStatus($data['orderReportDate'], $data['status']);

        $orderRows = $orders->map(function ($order) use ($inventoryStocks) {
            return [
                'id' => $order->id,
                'name' => $order->name,
                'orderDetails' => $this->reportTableBuilder->quantitiesPerItem($inventoryStocks, $order->orderDetails, 'inventory_stock_id'),
            ];
        })->all();

        return [
            'inventoryStocks' => $inventoryStocks,
            'orders' => $orderRows,
            // Footer is summed from the listed orders, so it respects the status filter
            'totalOrders' => $this->reportTableBuilder->totalPerItem($inventoryStocks, $orderRows, 'orderDetails'),
        ];
    }
}
