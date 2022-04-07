<?php

namespace App\Repositories\Transactions\Purchases;

use App\Models\Transactions\Purchases\Purchase;
use App\Models\Transactions\Purchases\PurchaseDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class PurchaseRepository implements PurchaseInterface
{
    public function getPurchases()
    {
        $sales = Purchase::all();

        return $sales;
    }

    public function storePurchase($data)
    {
        DB::beginTransaction();
        try {
            $sale = new Purchase;
            $purchaseId = Uuid::uuid4();
            $sale->id = $purchaseId;
            $sale->date = $data['date'];
            $sale->grand_total = $data['grandTotal'];
            $sale->notes = $data['notes'];
            $sale->save();

            if ($data['detail']) {
                for ($index = 0; $index < count($data['detail']); $index++) {
                    $purchaseDetail = new PurchaseDetail();
                    $purchaseDetail->id = Uuid::uuid4();
                    $purchaseDetail->purchase_id = $purchaseId;
                    $purchaseDetail->ingredient_id = $data['detail'][$index]['ingredient'];
                    $purchaseDetail->quantity = $data['detail'][$index]['quantity'];
                    $purchaseDetail->price = $data['detail'][$index]['price'];
                    $purchaseDetail->total = $data['detail'][$index]['total'];
                    $purchaseDetail->notes = $data['detail'][$index]['notes'];
                    $purchaseDetail->save();
                }
            }
            DB::commit();

            return $sale;
        } catch (Exception $exception) {
            DB::rollBack();
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
        DB::beginTransaction();
        try {
            $purchaseDetail = PurchaseDetail::where('purchase_id', $id);
            $purchaseDetail->delete();

            $purchase = Purchase::findOrFail($id);
            $purchase->delete();
            DB::commit();

            return [
                'purch$purchase' => $purchase,
                'purch$purchaseDetail' => $purchaseDetail,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Pembelian gagal dihapus.');
        }
    }

    public function getGrandTotalDailyPurchase()
    {
        $grandTotal = Purchase::where('date', Carbon::now())->sum('grand_total');

        return $grandTotal;
    }
}
