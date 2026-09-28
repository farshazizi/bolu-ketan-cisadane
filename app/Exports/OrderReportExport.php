<?php

namespace App\Exports;

use App\Exports\Concerns\AppliesTableBorders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;

class OrderReportExport implements FromView, WithEvents
{
    use AppliesTableBorders;

    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function registerEvents(): array
    {
        // Title + two header rows, one row per order, then the "Jumlah" footer
        $lastRow = 3 + count($this->report['orders']) + 1;

        // Columns: No, order name, one per inventory stock
        return $this->bordersEvent([
            $this->tableRange(1, $lastRow, 2 + count($this->report['inventoryStocks'])),
        ]);
    }

    public function view(): View
    {
        return view('contents.exports.order-report', $this->report);
    }
}
