<?php

namespace App\Http\Controllers\Reports;

use App\Exports\DailyReportExport;
use App\Exports\MonthlyReportExport;
use App\Exports\OrderReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\DailyReportRequest;
use App\Http\Requests\Reports\MonthlyReportRequest;
use App\Http\Requests\Reports\OrderReportRequest;
use App\Services\Reports\DailyReportService;
use App\Services\Reports\MonthlyReportService;
use App\Services\Reports\OrderReportService;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private $dailyReportService;
    private $monthlyReportService;
    private $orderReportService;

    public function __construct(MonthlyReportService $monthlyReportService, DailyReportService $dailyReportService, OrderReportService $orderReportService)
    {
        $this->dailyReportService = $dailyReportService;
        $this->monthlyReportService = $monthlyReportService;
        $this->orderReportService = $orderReportService;
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

        $dataDailyReport = $this->dailyReportService->dailyReport($date);

        return Excel::download(new DailyReportExport($dataDailyReport), "Laporan-Harian_$date.xlsx");
    }

    public function orderReport(OrderReportRequest $orderReportRequest)
    {
        // Request validate
        $request = $orderReportRequest->validated();

        // Set variabl from request
        $date = $request['orderReportDate'];

        $dataOrderReport = $this->orderReportService->orderReport($request);

        return Excel::download(new OrderReportExport($dataOrderReport), "Laporan-Pesanan_$date.xlsx");
    }

    public function monthlyReport(MonthlyReportRequest $monthlyReportRequest)
    {
        // Request validate
        $request = $monthlyReportRequest->validated();

        // Set variabl from request
        $date = $request['monthlyReportDate'];

        $dataMonthlyReport = $this->monthlyReportService->monthlyReport($date);

        return Excel::download(new MonthlyReportExport($dataMonthlyReport), "Laporan-Bulanan_$date.xlsx");
    }
}
