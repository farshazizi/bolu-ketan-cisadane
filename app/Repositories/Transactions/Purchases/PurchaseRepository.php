<?php

namespace App\Repositories\Transactions\Purchases;

use App\Models\Transactions\Purchases\Purchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class PurchaseRepository implements PurchaseInterface
{
    public function getPurchases()
    {
        $sales = Purchase::orderByDesc('date')->get();

        return $sales;
    }

    public function storePurchase($data)
    {
        try {
            $purchase = new Purchase;
            $purchase->id = Uuid::uuid4();
            $purchase->date = $data['date'];
            $purchase->grand_total = $data['grandTotal'];
            $purchase->notes = $data['notes'];
            $purchase->save();

            return $purchase;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pembelian gagal ditambahkan.');
        }
    }

    public function getPurchaseById($id)
    {
        $purchase = Purchase::has('purchaseDetails')->with('purchaseDetails.ingredient')->findOrFail($id);

        return $purchase;
    }

    public function destoryPurchaseById($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->delete();

            return $purchase;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pembelian gagal dihapus.');
        }
    }

    public function getGrandTotalDailyPurchase()
    {
        $grandTotal = Purchase::where('date', Carbon::today()->toDateString())->sum('grand_total');

        return $grandTotal;
    }

    public function getPurchasesByDate($date)
    {
        $purchases = Purchase::with('purchaseDetails')->where('date', $date)->orderBy('created_at')->get();

        return $purchases;
    }

    public function getPurchasesByMonth($month)
    {
        // $month is "YYYY-MM"; filter on year too so the same month of other years is excluded
        $date = Carbon::parse($month);
        $purchases = Purchase::with('purchaseDetails')
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->orderBy('date')
            ->orderBy('created_at')
            ->get();

        return $purchases;
    }
}
