<?php

namespace App\Http\Controllers\Reports;

use App\Exports\OrderReportExport;
use App\Exports\SalesPurchasesReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\DailyReportRequest;
use App\Http\Requests\Reports\MonthlyReportRequest;
use App\Http\Requests\Reports\OrderReportRequest;
use App\Services\Reports\OrderReportService;
use App\Services\Reports\SalesPurchasesReportService;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private $orderReportService;
    private $salesPurchasesReportService;

    public function __construct(OrderReportService $orderReportService, SalesPurchasesReportService $salesPurchasesReportService)
    {
        $this->orderReportService = $orderReportService;
        $this->salesPurchasesReportService = $salesPurchasesReportService;
    }

    public function index()
    {
        return view('contents.reports.index');
    }

    public function dailyReport(DailyReportRequest $dailyReportRequest)
    {
        $date = $dailyReportRequest->validated()['dailyReportDate'];

        $report = $this->salesPurchasesReportService->dailyReport($date);

        return Excel::download(new SalesPurchasesReportExport($report, SalesPurchasesReportExport::DAILY), "Laporan-Harian_$date.xlsx");
    }

    public function orderReport(OrderReportRequest $orderReportRequest)
    {
        $request = $orderReportRequest->validated();
        $date = $request['orderReportDate'];

        $report = $this->orderReportService->orderReport($request);

        return Excel::download(new OrderReportExport($report), "Laporan-Pesanan_$date.xlsx");
    }

    public function monthlyReport(MonthlyReportRequest $monthlyReportRequest)
    {
        $month = $monthlyReportRequest->validated()['monthlyReportDate'];

        $report = $this->salesPurchasesReportService->monthlyReport($month);

        return Excel::download(new SalesPurchasesReportExport($report, SalesPurchasesReportExport::MONTHLY), "Laporan-Bulanan_$month.xlsx");
    }
}
