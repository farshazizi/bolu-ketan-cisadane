<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DailyReportExport implements FromView, WithEvents
{
    protected $dataDailyReport;

    public function __construct($dataDailyReport)
    {
        $this->dataDailyReport = $dataDailyReport;
    }

    public function registerEvents(): array
    {
        // Set initial value
        $alphabet = config('properties.alphabet');

        //* Styling Sale Daily Report *//
        // Set variable and initial value
        $sales = $this->dataDailyReport['sales'];
        $inventoryStocks = $this->dataDailyReport['inventoryStocks'];
        $numberOfStaticColumnSale = 4;

        // Calculate end of column sale
        $totalInventoryStocks = count($inventoryStocks);
        $totalColumnSale = ($numberOfStaticColumnSale + $totalInventoryStocks) - 1;
        $endOfColumnSale = $alphabet[$totalColumnSale];

        $startColumnSale = $alphabet[0];
        $endColumnSale = $endOfColumnSale;
        $startRowHeaderSale = 1;
        $startRowContentSale = 3;
        $cellInitialSale = $startColumnSale . $startRowHeaderSale . ':' . $endColumnSale;

        $dataLengthSale = count($sales);
        $endRowSale = ($startRowContentSale + $dataLengthSale) + 1;
        $cellRangeSale = $cellInitialSale . $endRowSale;

        //* Styling Purchase Daily Report *//
        // Set variable and initial value
        $purchases = $this->dataDailyReport['purchases'];
        $ingredients = $this->dataDailyReport['ingredients'];
        $numberOfStaticColumnPurchase = 3;

        // Calculate end of column purchase
        $totalIngredients = count($ingredients);
        $totalColumnPurchase = ($numberOfStaticColumnPurchase + $totalIngredients) - 1;
        $endOfColumnPurchase = $alphabet[$totalColumnPurchase];

        $startColumnPurchase = $alphabet[0];
        $endColumnPurchase = $endOfColumnPurchase;
        $startRowHeaderPurchase = $endRowSale + 6;
        $startRowContentPurchase = $startRowHeaderPurchase + 2;
        $cellInitialPurchase = $startColumnPurchase . $startRowHeaderPurchase . ':' . $endColumnPurchase;

        $dataLengthPurchase = count($purchases);
        $endRowPurchase = ($startRowContentPurchase + $dataLengthPurchase) + 1;
        $cellRangePurchase = $cellInitialPurchase . $endRowPurchase;

        //* Styling Balance Daily Report *//
        // Set variable and initial value
        $numberOfStaticColumnBalance = 3;

        // Calculate end of column balance
        $totalColumnBalance = $numberOfStaticColumnBalance - 1;
        $endOfColumnBalance = $alphabet[$totalColumnBalance];

        $startColumnBalance = $alphabet[0];
        $endColumnBalance = $endOfColumnBalance;
        $startRowHeaderBalance = $endRowPurchase + 6;
        $startRowContentBalance = $startRowHeaderBalance;
        $cellInitialBalance = $startColumnBalance . $startRowHeaderBalance . ':' . $endColumnBalance;

        $dataLengthBalance = 1;
        $endRowBalance = ($startRowContentBalance + $dataLengthBalance);
        $cellRangeBalance = $cellInitialBalance . $endRowBalance;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellRangeSale, $cellRangePurchase, $cellRangeBalance) {
                $event->getSheet()->getDelegate()->getStyle($cellRangeSale)->applyFromArray(
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ]
                        ]
                    ]
                );
                $event->getSheet()->getDelegate()->getStyle($cellRangePurchase)->applyFromArray(
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ]
                        ]
                    ]
                );
                $event->getSheet()->getDelegate()->getStyle($cellRangeBalance)->applyFromArray(
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ]
                        ]
                    ]
                );
            }
        ];
    }

    public function view(): View
    {
        $inventoryStocks = $this->dataDailyReport['inventoryStocks'];
        $sales = $this->dataDailyReport['sales'];
        $sumTotalAdditionalSales = $this->dataDailyReport['sumTotalAdditionalSales'];
        $totalSales = $this->dataDailyReport['totalSales'];
        $sumGrandTotalSales = $this->dataDailyReport['sumGrandTotalSales'];
        $ingredients = $this->dataDailyReport['ingredients'];
        $purchases = $this->dataDailyReport['purchases'];
        $totalPurchases = $this->dataDailyReport['totalPurchases'];
        $sumGrandTotalPurchases = $this->dataDailyReport['sumGrandTotalPurchases'];

        return view('contents.exports.daily-report', [
            'inventoryStocks' => $inventoryStocks,
            'sales' => $sales,
            'sumTotalAdditionalSales' => $sumTotalAdditionalSales,
            'totalSales' => $totalSales,
            'sumGrandTotalSales' => $sumGrandTotalSales,
            'ingredients' => $ingredients,
            'purchases' => $purchases,
            'totalPurchases' => $totalPurchases,
            'sumGrandTotalPurchases' => $sumGrandTotalPurchases
        ]);
    }
}
