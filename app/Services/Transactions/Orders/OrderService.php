<?php

namespace App\Services\Transactions\Orders;

use App\Repositories\Transactions\Orders\OrderRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function data()
    {
        $orders = $this->orderRepository->getOrders();

        return $orders;
    }

    public function storeOrder($data)
    {
        try {
            $order = $this->orderRepository->storeOrder($data);

            return $order;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pesanan gagal ditambahkan.');
        }
    }

    public function getOrderById($id, $formatting = null)
    {
        $order = $this->orderRepository->getOrderById($id);

        if ($order) {
            if (is_null($formatting)) {
                $order->grand_total = number_format($order->grand_total, 0);
                $orderDetails = $order->orderDetails;
                for ($index = 0; $index < count($orderDetails); $index++) {
                    $orderDetails[$index]->quantity = number_format($orderDetails[$index]->quantity, 0);
                    $orderDetails[$index]->price = number_format($orderDetails[$index]->price, 0);
                    $orderDetails[$index]->total = number_format($orderDetails[$index]->total, 0);
                    $orderDetails[$index]->total_additional = number_format($orderDetails[$index]->total_additional, 0);

                    $orderAdditionalDetails = $order->orderDetails[$index]->orderAdditionalDetails;
                    for ($indexAdditional = 0; $indexAdditional < count($orderAdditionalDetails); $indexAdditional++) {
                        $orderAdditionalDetails[$indexAdditional]->price = number_format($orderAdditionalDetails[$indexAdditional]->price, 0);
                    }
                }
            }
        }

        return $order;
    }

    public function destroyInventoryStockById($id)
    {
        try {
            $order = $this->orderRepository->destoryOrderById($id);

            return $order;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pesanan gagal dihapus.');
        }
    }

    public function getGrandTotalDailyOrder()
    {
        $grandTotal = $this->orderRepository->getGrandTotalDailyOrder();

        return $grandTotal;
    }

    public function dataOrdersWaiting ()
    {
        $orders = $this->orderRepository->getOrdersWaiting();

        return $orders;
    }
}
