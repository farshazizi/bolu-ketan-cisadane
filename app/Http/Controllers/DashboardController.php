<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $dashboardData = $this->dashboardService->getDashboardData();

        // Format the numbers
        $dashboardData['dailyBalance'] = number_format($dashboardData['dailyBalance'], 0);
        $dashboardData['grandTotalPurchase'] = number_format($dashboardData['grandTotalPurchase'], 0);
        $dashboardData['grandTotalSale'] = number_format($dashboardData['grandTotalSale'], 0);

        return view('layouts.dashboard', $dashboardData);
    }

    public function data()
    {
        $data = $this->dashboardService->getOrdersWaitingData();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('totalOrder', function ($order) {
                $totalOrder = count($order->orderDetails);

                return $totalOrder;
            })
            ->editColumn('date', function ($order) {
                $date = Carbon::parse($order->date)->locale('id')->translatedFormat('d-M-Y');

                return $date;
            })
            ->addColumn('action', function ($additional) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="#" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-id="' . $additional->id . '"><i class="far fa-eye fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }
}
