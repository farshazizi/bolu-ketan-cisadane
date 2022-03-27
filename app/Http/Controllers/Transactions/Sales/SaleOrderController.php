<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Services\Transactions\Orders\OrderService;
use Carbon\Carbon;

class SaleOrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function data()
    {
        $data = $this->orderService->dataOrdersWaiting();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('date', function ($order) {
                $date = Carbon::parse($order->date)->locale('id')->translatedFormat('d-M-Y');
                return $date;
            })
            ->addColumn('action', function ($order) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <input type="radio" id="orderId" name="orderId" value="' . $order->id . '"/>
                </div>
                ');
            })
            ->toJson();
    }
}
