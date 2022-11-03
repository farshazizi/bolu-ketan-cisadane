<?php

namespace App\Http\Controllers\Reports;

use App\Exports\DailyReportExport;
use App\Exports\OrderReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\DailyReportRequest;
use App\Http\Requests\Reports\OrderReportRequest;
use App\Services\Reports\ReportService;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        return view('contents.reports.index');
    }

    public function dailyReport(DailyReportRequest $dailyReportRequest)
    {
        // Request validate
        $request = $dailyReportRequest->validated();

        // Set variabl from request
        $date = $request['dailyReportDate'];

        $dataDailyReport = $this->reportService->dailyReport($date);

        return Excel::download(new DailyReportExport($dataDailyReport), "Laporan-Harian_$date.xlsx");
    }

    public function orderReport(OrderReportRequest $orderReportRequest)
    {
        // Request validate
        $request = $orderReportRequest->validated();

        // Set variabl from request
        $date = $request['orderReportDate'];
        $status = $request['status'];

        return Excel::download(new OrderReportExport($date, $status), "Laporan-Pesanan_$date.xlsx");
    }
}
