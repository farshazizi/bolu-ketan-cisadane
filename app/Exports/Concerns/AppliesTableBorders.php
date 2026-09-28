<?php

namespace App\Exports\Concerns;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;

trait AppliesTableBorders
{
    /**
     * Build a cell range like "A1:G6" spanning $columnCount columns from $firstRow to $lastRow.
     */
    protected function tableRange($firstRow, $lastRow, $columnCount)
    {
        return 'A' . $firstRow . ':' . Coordinate::stringFromColumnIndex($columnCount) . $lastRow;
    }

    protected function bordersEvent(array $ranges)
    {
        return [
            AfterSheet::class => function (AfterSheet $event) use ($ranges) {
                foreach ($ranges as $range) {
                    $event->getSheet()->getDelegate()->getStyle($range)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ]);
                }
            },
        ];
    }
}
