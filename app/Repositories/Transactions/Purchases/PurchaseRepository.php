<?php

namespace App\Repositories\Transactions\Purchases;

use App\Models\Transactions\Purchases\Purchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
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
        $grandTotal = Purchase::where('date', Carbon::now())->sum('grand_total');

        return $grandTotal;
    }

    public function getPurchasesByDate($date)
    {
        $purchases = Purchase::with('purchaseDetails.ingredient')->where('date', $date)->orderBy('created_at')->get();

        return $purchases;
    }

    public function getTotalPurchasesByDate($date)
    {
        $totalPurchases = DB::table('purchases as p')
            ->join('purchase_details as pd', 'pd.purchase_id', '=', 'p.id')
            ->leftJoin('ingredients as i', 'i.id', '=', 'pd.ingredient_id')
            ->groupBy('i.id')
            ->where('p.date', $date)
            ->whereNull('p.deleted_at')
            ->whereNull('pd.deleted_at')
            ->orderBy('i.name')
            ->select('i.id', 'i.name', DB::raw('SUM(pd.quantity) as quantity'))
            ->get();

        return $totalPurchases;
    }

    public function getPurchasesByMonth($month)
    {
        $purchases = Purchase::with('purchaseDetails.ingredient')->whereMonth('date', $month)->orderBy('created_at')->get();

        return $purchases;
    }

    public function getTotalPurchasesByMonth($month)
    {
        $totalPurchases = DB::table('purchases as p')
            ->join('purchase_details as pd', 'pd.purchase_id', '=', 'p.id')
            ->leftJoin('ingredients as i', 'i.id', '=', 'pd.ingredient_id')
            ->groupBy('i.id')
            ->whereMonth('p.date', $month)
            ->whereNull('p.deleted_at')
            ->whereNull('pd.deleted_at')
            ->orderBy('i.name')
            ->select('i.id', 'i.name', DB::raw('SUM(pd.quantity) as quantity'))
            ->get();

        return $totalPurchases;
    }
}
