<?php

namespace App\Repositories\Transactions\Purchases;

use App\Models\Transactions\Purchases\PurchaseDetail;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class PurchaseDetailRepository implements PurchaseDetailInterface
{
    public function storePurchaseDetail($data, $purchaseId)
    {
        try {
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

            return $purchaseDetail;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pembelian detil gagal ditambahkan.');
        }
    }

    public function destoryPurchaseDetailsByPurchaseId($purchaseId)
    {
        try {
            $purchaseDetails = PurchaseDetail::where('purchase_id', $purchaseId);
            $purchaseDetails->delete();


            return $purchaseDetails;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pembelian detil gagal dihapus.');
        }
    }
}
