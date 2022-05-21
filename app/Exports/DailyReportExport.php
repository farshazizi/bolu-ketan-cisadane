<?php

namespace App\Exports;

use App\Models\Transactions\Purchases\Purchase;
use App\Models\Transactions\Sales\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DailyReportExport implements FromView
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        // Get data sale
        $sales = Sale::with('saleDetails.inventoryStock')->where('date', $this->date)->get();

        // Mapping sale
        $dataSales = [];
        $totalDebit = 0;
        foreach ($sales as $key => $sale) {
            foreach ($sale->saleDetails as $salesDetail) {
                $dataSales[$key] = [
                    "name" => $salesDetail->inventoryStock->name,
                    "quantity" => $salesDetail->quantity,
                    "price" => $salesDetail->price,
                    "debit" => $salesDetail->quantity * $salesDetail->price,
                ];
                $totalDebit += $salesDetail->quantity * $salesDetail->price;
            }
        }

        // Get data purchase
        $purchases = Purchase::with('purchaseDetails.ingredient')->where('date', $this->date)->get();

        // Mapping purchase
        $dataPurchases = [];
        $totalKredit = 0;
        foreach ($purchases as $key => $purchase) {
            foreach ($purchase->purchaseDetails as $purchasesDetail) {
                $dataPurchases[$key] = [
                    "name" => $purchasesDetail->ingredient->name,
                    "quantity" => $purchasesDetail->quantity,
                    "price" => $purchasesDetail->price,
                    "kredit" => $purchasesDetail->quantity * $purchasesDetail->price,
                ];
                $totalKredit += $purchasesDetail->quantity * $purchasesDetail->price;
            }
        }

        // Calculate balance
        $balance = $totalDebit - $totalKredit;

        return view('contents.exports.daily-report', [
            'sales' => $dataSales,
            'purchases' => $dataPurchases,
            'balance' => $balance
        ]);
    }
}
