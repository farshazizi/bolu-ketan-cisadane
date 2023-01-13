<?php

namespace App\Services\Transactions\Purchases;

use App\Repositories\Transactions\Purchases\PurchaseDetailRepository;
use App\Repositories\Transactions\Purchases\PurchaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseService
{
    private $purchaseDetailRepository;
    private $purchaseRepository;

    public function __construct(PurchaseDetailRepository $purchaseDetailRepository, PurchaseRepository $purchaseRepository)
    {
        $this->purchaseDetailRepository = $purchaseDetailRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function data()
    {
        $purchases = $this->purchaseRepository->getPurchases();

        return $purchases;
    }

    public function storePurchase($data)
    {
        DB::beginTransaction();
        try {
            // Add Purchase
            $purchase = $this->purchaseRepository->storePurchase($data);

            // Add Purchase Detail
            $this->purchaseDetailRepository->storePurchaseDetail($data, $purchase->id);

            DB::commit();

            return $purchase;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw $exception;
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
        DB::beginTransaction();
        try {
            // Delete Purchase Detail
            $this->purchaseDetailRepository->destoryPurchaseDetailsByPurchaseId($id);

            // Delete Purchase
            $purchase = $this->purchaseRepository->destoryPurchaseById($id);

            DB::commit();

            return $purchase;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw $exception;
        }
    }

    public function getGrandTotalDailyPurchase()
    {
        $grandTotal = $this->purchaseRepository->getGrandTotalDailyPurchase();

        return $grandTotal;
    }
}
