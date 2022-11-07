<?php

namespace App\Services\Reports;

use App\Repositories\Masters\InventoryStocks\InventoryStockRepository;
use App\Repositories\Transactions\Orders\OrderRepository;
use Carbon\Carbon;

class OrderService
{
    private $inventoryStockRepository;
    private $orderRepository;

    public function __construct(InventoryStockRepository $inventoryStockRepository, OrderRepository $orderRepository)
    {
        $this->inventoryStockRepository = $inventoryStockRepository;
        $this->orderRepository = $orderRepository;
    }

    public function orderReport($data)
    {
        // Set variable
        $date = $data['orderReportDate'];
        $status = $data['status'];

        // Set initial value
        $data = [];

        // Get inventory stocks
        $inventoryStocks = $this->inventoryStockRepository->getInventoryStocks();
        $inventoryStocks = $inventoryStocks->orderBy('name')->get();

        // Get data orders
        $orders = $this->orderRepository->getOrdersByDateAndStatus($date, $status);

        // Grouping orders
        $groupingOrders = $this->groupingOrders($inventoryStocks, $orders);

        // Get total orders
        $totalOrders = $this->orderRepository->getTotalOrdersByDate($date);

        // Calculate total sales
        $dataTotalOrders = $this->calculateTotalOrders($inventoryStocks, $totalOrders);

        $data = [
            'inventoryStocks' => $inventoryStocks,
            'orders' => $groupingOrders,
            'totalOrders' => $dataTotalOrders
        ];

        return $data;
    }

    public function groupingOrders($inventoryStocks, $orders)
    {
        // Set initial value
        $groupingOrders = [];

        foreach ($orders as $keyOrder => $order) {
            // Set variable
            $orderId = $order->id;
            $name = $order->name;
            $createdAt = Carbon::parse($order->created_at)->format('H:i');

            // Mapping key object
            $groupingOrders[$keyOrder]['id'] = $orderId;
            $groupingOrders[$keyOrder]['name'] = $name;
            $groupingOrders[$keyOrder]['createdAt'] = $createdAt;

            foreach ($inventoryStocks as $keyInventoryStock => $inventoryStock) {
                // Set initial value
                $totalQuantity = 0;

                // Set variable
                $inventoryStockId = $inventoryStock->id;
                $name = $inventoryStock->name;

                // Mapping key object
                $groupingOrders[$keyOrder]['orderDetails'][$keyInventoryStock]['id'] = $inventoryStockId;
                $groupingOrders[$keyOrder]['orderDetails'][$keyInventoryStock]['name'] = $name;
                $groupingOrders[$keyOrder]['orderDetails'][$keyInventoryStock]['quantity'] = 0;

                foreach ($order->orderDetails as $orderDetail) {
                    // Set variable
                    $inventoryStockId = $orderDetail->inventory_stock_id;
                    $quantity = $orderDetail->quantity;

                    if ($groupingOrders[$keyOrder]['orderDetails'][$keyInventoryStock]['id'] == $inventoryStockId) {
                        $totalQuantity += $quantity;
                    }
                }

                $groupingOrders[$keyOrder]['orderDetails'][$keyInventoryStock]['quantity'] = $totalQuantity;
            }
        }

        return $groupingOrders;
    }

    public function calculateTotalOrders($inventoryStocks, $totalOrders)
    {
        // Set initial value
        $dataTotalOrders = [];

        foreach ($inventoryStocks as $keyInventoryStock => $inventoryStock) {
            // Set variable
            $inventoryStockId = $inventoryStock->id;
            $name = $inventoryStock->name;

            $dataTotalOrders[$keyInventoryStock]['id'] = $inventoryStockId;
            $dataTotalOrders[$keyInventoryStock]['name'] = $name;
            $dataTotalOrders[$keyInventoryStock]['quantity'] = 0;

            foreach ($totalOrders as $totalOrder) {
                // Set variable
                $inventoryStockId = $totalOrder->id;
                $quantity = $totalOrder->quantity;

                if ($dataTotalOrders[$keyInventoryStock]['id'] === $inventoryStockId) {
                    $dataTotalOrders[$keyInventoryStock]['quantity'] = $quantity;
                }
            }
        }

        return $dataTotalOrders;
    }
}