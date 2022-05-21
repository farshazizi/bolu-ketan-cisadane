<?php

namespace App\Exports;

use App\Models\Transactions\Orders\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderReportExport implements FromView
{
    protected $date;
    protected $status;

    public function __construct($date, $status)
    {
        $this->date = $date;
        $this->status = $status;
    }

    public function view(): View
    {
        $orders = Order::with('orderDetails.inventoryStock')->where('date', $this->date)->get();
        
        return view('contents.exports.order-report', [
            'data' => $orders
        ]);
    }
}
