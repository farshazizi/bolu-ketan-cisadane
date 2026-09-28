<?php

namespace App\Exports;

use App\Exports\Concerns\AppliesTableBorders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;

class SalesPurchasesReportExport implements FromView, WithEvents
{
    use AppliesTableBorders;

    // Title row + two header rows before the data, and the "Jumlah" footer after it
    private const HEADER_ROWS = 3;
    private const FOOTER_ROWS = 1;
    // Blank rows the view puts between tables
    private const GAP_ROWS = 5;

    const DAILY = 'daily';
    const MONTHLY = 'monthly';

    protected $report;
    protected $period;

    public function __construct($report, $period)
    {
        $this->report = $report;
        $this->period = $period;
    }

    public function registerEvents(): array
    {
        // Sale columns: No, time/date, one per inventory stock, total additional, debit
        $saleFirstRow = 1;
        $saleLastRow = $saleFirstRow + self::HEADER_ROWS + count($this->report['sales']) + self::FOOTER_ROWS - 1;

        // Purchase columns: No, time/date, one per ingredient, debit
        $purchaseFirstRow = $saleLastRow + self::GAP_ROWS + 1;
        $purchaseLastRow = $purchaseFirstRow + self::HEADER_ROWS + count($this->report['purchases']) + self::FOOTER_ROWS - 1;

        // Balance: sale, purchase, balance; header row + value row
        $balanceFirstRow = $purchaseLastRow + self::GAP_ROWS + 1;

        return $this->bordersEvent([
            $this->tableRange($saleFirstRow, $saleLastRow, 4 + count($this->report['inventoryStocks'])),
            $this->tableRange($purchaseFirstRow, $purchaseLastRow, 3 + count($this->report['ingredients'])),
            $this->tableRange($balanceFirstRow, $balanceFirstRow + 1, 3),
        ]);
    }

    public function view(): View
    {
        $isDaily = $this->period === self::DAILY;

        return view('contents.exports.sales-purchases-report', $this->report + [
            'periodLabel' => $isDaily ? 'HARIAN' : 'BULANAN',
            'timeColumnLabel' => $isDaily ? 'Jam Transaksi' : 'Tanggal Transaksi',
            'timeField' => $isDaily ? 'createdAt' : 'date',
        ]);
    }
}
