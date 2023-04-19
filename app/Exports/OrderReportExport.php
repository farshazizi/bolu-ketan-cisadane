<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderReportExport implements FromView, WithEvents
{
    protected $dataOrderReport;

    public function __construct($dataOrderReport)
    {
        $this->dataOrderReport = $dataOrderReport;
    }

    public function registerEvents(): array
    {
        // Set initial value
        $alphabet = config('properties.alphabet');

        // Set variable and initial value
        $orders = $this->dataOrderReport['orders'];
        $inventoryStocks = $this->dataOrderReport['inventoryStocks'];
        $numberOfStaticColumnOrder = 2;

        // Calculate end of column order
        $totalInventoryStocks = count($inventoryStocks);
        $totalColumnOrder = ($numberOfStaticColumnOrder + $totalInventoryStocks) - 1;
        $endOfColumnOrder = $alphabet[$totalColumnOrder];

        $startColumnOrder = $alphabet[0];
        $endColumnOrder = $endOfColumnOrder;
        $startRowHeaderOrder = 1;
        $startRowContentOrder = 3;
        $cellInitialSale = $startColumnOrder . $startRowHeaderOrder . ':' . $endColumnOrder;

        $dataLengthOrder = count($orders);
        $endRowOrder = ($startRowContentOrder + $dataLengthOrder) + 1;
        $cellRangeOrder = $cellInitialSale . $endRowOrder;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellRangeOrder) {
                $event->getSheet()->getDelegate()->getStyle($cellRangeOrder)->applyFromArray(
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
        $inventoryStocks = $this->dataOrderReport['inventoryStocks'];
        $orders = $this->dataOrderReport['orders'];
        $totalOrders = $this->dataOrderReport['totalOrders'];

        return view('contents.exports.order-report', [
            'inventoryStocks' => $inventoryStocks,
            'orders' => $orders,
            'totalOrders' => $totalOrders,
        ]);
    }
}
