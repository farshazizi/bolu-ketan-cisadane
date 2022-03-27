<?php

namespace App\Services\Transactions\Purchases;

use App\Repositories\Transactions\Purchases\PurchaseRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class PurchaseService
{
    private $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function data()
    {
        $purchases = $this->purchaseRepository->getPurchases();

        return $purchases;
    }

    public function storePurchase($data)
    {
        try {
            $purchase = $this->purchaseRepository->storePurchase($data);

            return $purchase;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pembelian gagal ditambahkan.');
        }
    }

    public function getPurchaseById($id)
    {
        $purchase = $this->purchaseRepository->getPurchaseById($id);

        if ($purchase) {
            $purchase->grand_total = number_format($purchase->grand_total, 0);
            $purchaseDetails = $purchase->purchaseDetails;
            for ($index = 0; $index < count($purchaseDetails); $index++) {
                $purchaseDetails[$index]->quantity = number_format($purchaseDetails[$index]->quantity, 0);
                $purchaseDetails[$index]->price = number_format($purchaseDetails[$index]->price, 0);
                $purchaseDetails[$index]->total = number_format($purchaseDetails[$index]->total, 0);
            }
        }

        return $purchase;
    }

    public function destroyPurchaseById($id)
    {
        try {
            $purchase = $this->purchaseRepository->destoryPurchaseById($id);

            return $purchase;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Pembelian gagal dihapus.');
        }
    }

    public function getGrandTotalDailyPurchase()
    {
        $grandTotal = $this->purchaseRepository->getGrandTotalDailyPurchase();

        return $grandTotal;
    }
}
