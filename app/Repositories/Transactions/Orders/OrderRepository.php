<?php

namespace App\Repositories\Transactions\Orders;

use App\Models\Transactions\Orders\Order;
use App\Models\Transactions\Orders\OrderAdditionalDetail;
use App\Models\Transactions\Orders\OrderDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class OrderRepository implements OrderInterface
{
    public function getOrders()
    {
        $orders = Order::orderBy('date', 'desc')->get();

        return $orders;
    }

    public function storeOrder($data)
    {
        DB::beginTransaction();
        try {
            $order = new Order;
            $orderId = Uuid::uuid4();
            $order->id = $orderId;
            $order->date = $data['date'];
            $order->name = $data['name'];
            $order->address = $data['address'];
            $order->phone = $data['phone'];
            $order->grand_total = $data['grandTotal'];
            $order->notes = $data['notes'];
            $order->status = $data['status'];
            $order->save();

            if ($data['detail']) {
                for ($index = 0; $index < count($data['detail']); $index++) {
                    $orderDetail = new OrderDetail();
                    $orderDetailId = Uuid::uuid4();
                    $orderDetail->id = $orderDetailId;
                    $orderDetail->order_id = $orderId;
                    $orderDetail->inventory_stock_id = $data['detail'][$index]['inventoryStock'];
                    $orderDetail->quantity = $data['detail'][$index]['quantity'];
                    $orderDetail->price = $data['detail'][$index]['price'];
                    $orderDetail->total = $data['detail'][$index]['total'];
                    $orderDetail->total_additional = $data['detail'][$index]['totalAdditional'];
                    $orderDetail->notes = $data['detail'][$index]['notes'];
                    $orderDetail->save();

                    if ($data['detailAdditional']) {
                        for ($indexAdditional = 0; $indexAdditional < count($data['detailAdditional']); $indexAdditional++) {
                            if ($data['detailAdditional'][$indexAdditional]['keyDetail'] == $index) {
                                $orderAdditionalDetail = new OrderAdditionalDetail();
                                $orderAdditionalDetail->id = Uuid::uuid4();
                                $orderAdditionalDetail->order_detail_id = $orderDetailId;
                                $orderAdditionalDetail->additional_id = $data['detailAdditional'][$indexAdditional]['additionalId'];
                                $orderAdditionalDetail->price = $data['detailAdditional'][$indexAdditional]['price'];
                                $orderAdditionalDetail->save();
                            }
                        }
                    }
                }
            }
            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Penjualan gagal ditambahkan.');
        }
    }

    public function getOrderById($id)
    {
        $order = Order::has('orderDetails')
            ->with(['orderDetails.inventoryStock', 'orderDetails.orderAdditionalDetails.additional'])
            ->where('id', $id)
            ->first();

        return $order;
    }

    public function updateOrder($data, $id)
    {
        DB::beginTransaction();
        try {
            // Delete order additional detail
            $orderDetail = OrderDetail::select('id')->where('order_id', $id)->first();
            $orderDetailId = $orderDetail->id;
            $orderAdditionalDetail = OrderAdditionalDetail::where('order_detail_id', $orderDetailId);
            $orderAdditionalDetail->delete();

            // Delete order detail
            $orderDetail = OrderDetail::where('order_id', $id);
            $orderDetail->delete();

            $order = Order::where('id', $id)->first();
            $order->date = $data['date'];
            $order->name = $data['name'];
            $order->address = $data['address'];
            $order->phone = $data['phone'];
            $order->grand_total = $data['grandTotal'];
            $order->notes = $data['notes'];
            $order->status = $data['status'];
            $order->save();

            if ($data['detail']) {
                for ($index = 0; $index < count($data['detail']); $index++) {
                    $orderDetail = new OrderDetail();
                    $orderDetailId = Uuid::uuid4();
                    $orderDetail->id = $orderDetailId;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->inventory_stock_id = $data['detail'][$index]['inventoryStock'];
                    $orderDetail->quantity = $data['detail'][$index]['quantity'];
                    $orderDetail->price = $data['detail'][$index]['price'];
                    $orderDetail->total = $data['detail'][$index]['total'];
                    $orderDetail->total_additional = $data['detail'][$index]['totalAdditional'];
                    $orderDetail->notes = $data['detail'][$index]['notes'];
                    $orderDetail->save();

                    if ($data['detailAdditional']) {
                        for ($indexAdditional = 0; $indexAdditional < count($data['detailAdditional']); $indexAdditional++) {
                            if ($data['detailAdditional'][$indexAdditional]['index'] == $index) {
                                $orderAdditionalDetail = new OrderAdditionalDetail();
                                $orderAdditionalDetailId = Uuid::uuid4();
                                $orderAdditionalDetail->id = $orderAdditionalDetailId;
                                $orderAdditionalDetail->order_detail_id = $orderDetailId;
                                $orderAdditionalDetail->additional_id = $data['detailAdditional'][$indexAdditional]['additionalId'];
                                $orderAdditionalDetail->price = $data['detailAdditional'][$indexAdditional]['price'];
                                $orderAdditionalDetail->save();
                            }
                        }
                    }
                }
            }
            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Penjualan gagal ditambahkan.');
        }
    }

    public function destoryOrderById($id)
    {
        DB::beginTransaction();
        try {
            // Delete order additional detail
            $orderDetail = OrderDetail::select('id')->where('order_id', $id)->first();
            $orderDetailId = $orderDetail->id;
            $orderAdditionalDetail = OrderAdditionalDetail::where('order_detail_id', $orderDetailId);
            $orderAdditionalDetail->delete();

            // Delete order detail
            $orderDetail = OrderDetail::where('order_id', $id);
            $orderDetail->delete();

            // Delete order
            $order = Order::findOrFail($id);
            $order->delete();
            DB::commit();

            return [
                'order' => $order,
                'orderDetail' => $orderDetail,
                'orderAdditionalDetail' => $orderAdditionalDetail,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Penjualan gagal dihapus.');
        }
    }

    public function getStockByInventoryStockId($id)
    {
        $stockDetail = OrderDetail::where('inventory_stock_id', $id)->get();

        return $stockDetail;
    }

    public function getGrandTotalDailyOrder()
    {
        $grandTotal = Order::sum('grand_total');

        return $grandTotal;
    }

    public function getOrdersWaiting()
    {
        $orders = Order::with('orderDetails')->where('status', 0);

        return $orders;
    }

    public function getOrdersByDateAndStatus($date, $status)
    {
        $orders = Order::where('date', $date)->where('status', $status)->get();

        return $orders;
    }

    public function getTotalOrdersByDate($date)
    {
        $totalOrders = DB::table('orders as o')
            ->join('order_details as od', 'od.order_id', '=', 'o.id')
            ->leftJoin('inventory_stocks as is', 'is.id', '=', 'od.inventory_stock_id')
            ->groupBy('is.id')
            ->where('o.date', $date)
            ->whereNull('o.deleted_at')
            ->whereNull('od.deleted_at')
            ->orderBy('is.name')
            ->select('is.id', 'is.name', DB::raw('SUM(od.quantity) as quantity'))
            ->get();

        return $totalOrders;
    }

    public function setOrderStatusSuccessById($id)
    {
        $order = Order::where('id', $id)->update(['status' => 1]);

        return $order;
    }

    public function setOrderStatusFailedById($id)
    {
        $order = Order::where('id', $id)->update(['status' => 0]);

        return $order;
    }
}
