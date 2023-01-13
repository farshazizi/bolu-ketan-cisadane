<?php

namespace App\Repositories\Transactions\Sales;

use App\Models\Transactions\Sales\SaleAdditionalDetail;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class SaleAdditionalDetailRepository implements SaleAdditionalDetailInterface
{
    public function getSaleAdditionalDetails($saleDetailId)
    {
        $saleAdditionalDetails = SaleAdditionalDetail::with('additional')
            ->where('sale_detail_id', $saleDetailId)
            ->get();

        return $saleAdditionalDetails;
    }

    public function storeSaleAdditionalDetail($data, $saleDetail)
    {
        try {
            if ($data['detail']) {
                for ($index = 0; $index < count($data['detail']); $index++) {
                    if ($data['detailAdditional']) {
                        for ($indexAdditional = 0; $indexAdditional < count($data['detailAdditional']); $indexAdditional++) {
                            if ($data['detailAdditional'][$indexAdditional]['keyDetail'] == $index) {
                                $saleAdditionalDetail = new SaleAdditionalDetail();
                                $saleAdditionalDetail->id = Uuid::uuid4();
                                $saleAdditionalDetail->sale_detail_id = $saleDetail->id;
                                $saleAdditionalDetail->additional_id = $data['detailAdditional'][$indexAdditional]['additionalId'];
                                $saleAdditionalDetail->price = $data['detailAdditional'][$indexAdditional]['price'];
                                $saleAdditionalDetail->save();
                            }
                        }
                    }
                }
            }

            return $saleAdditionalDetail;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Penjualan Detil Tambahan gagal ditambahkan.');
        }
    }

    public function destorySaleAdditionalDetailsBySaleId($saleId)
    {
        try {
            $saleAdditionalDetails = SaleAdditionalDetail::whereHas('saleDetail.sale', function ($query) use ($saleId) {
                $query->where('sale.id', $saleId);
            })->get()->each(function ($query) {
                $query->delete();
            });

            return $saleAdditionalDetails;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Penjualan Detil Tambahan gagal dihapus.');
        }
    }
}
