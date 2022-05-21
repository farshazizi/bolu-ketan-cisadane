<?php

namespace App\Http\Controllers\Reports;

use App\Exports\DailyReportExport;
use App\Exports\OrderReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\DailyReportRequest;
use App\Http\Requests\Reports\OrderReportRequest;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('contents.reports.index');
    }

    public function dailyReport(DailyReportRequest $dailyReportRequest)
    {
        $request = $dailyReportRequest->safe()->collect();

        $date = $request['date'];

        return Excel::download(new DailyReportExport($date), "Laporan-Harian_$date.xlsx");
    }

    public function orderReport(OrderReportRequest $orderReportRequest)
    {
        $request = $orderReportRequest->safe()->collect();

        $date = $request['date'];
        $status = $request['status'];

        return Excel::download(new OrderReportExport($date, $status), "Laporan-Pesanan_$date.xlsx");
    }
}
