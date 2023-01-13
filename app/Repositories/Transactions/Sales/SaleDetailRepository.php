<?php

namespace App\Repositories\Transactions\Sales;

use App\Models\Transactions\Sales\SaleAdditionalDetail;
use App\Models\Transactions\Sales\SaleDetail;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class SaleDetailRepository implements SaleDetailInterface
{
    public function storeSaleDetail($data, $saleId)
    {
        try {
            if ($data['detail']) {
                for ($index = 0; $index < count($data['detail']); $index++) {
                    $saleDetail = new SaleDetail;
                    $saleDetailId = Uuid::uuid4();
                    $saleDetail->id = $saleDetailId;
                    $saleDetail->sale_id = $saleId;
                    $saleDetail->inventory_stock_id = $data['detail'][$index]['inventoryStock'];
                    $saleDetail->quantity = $data['detail'][$index]['quantity'];
                    $saleDetail->price = $data['detail'][$index]['price'];
                    $saleDetail->discount = $data['detail'][$index]['discount'];
                    $saleDetail->total = $data['detail'][$index]['total'];
                    $saleDetail->total_additional = $data['detail'][$index]['totalAdditional'];
                    $saleDetail->notes = $data['detail'][$index]['notes'];
                    $saleDetail->save();

                    if ($data['detailAdditional']) {
                        for ($indexAdditional = 0; $indexAdditional < count($data['detailAdditional']); $indexAdditional++) {
                            if ($data['detailAdditional'][$indexAdditional]['keyDetail'] == $index) {
                                $saleAdditionalDetail = new SaleAdditionalDetail();
                                $saleAdditionalDetail->id = Uuid::uuid4();
                                $saleAdditionalDetail->sale_detail_id = $saleDetailId;
                                $saleAdditionalDetail->additional_id = $data['detailAdditional'][$indexAdditional]['additionalId'];
                                $saleAdditionalDetail->price = $data['detailAdditional'][$indexAdditional]['price'];
                                $saleAdditionalDetail->save();
                            }
                        }
                    }
                }
            }

            return $saleDetail;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Penjualan Detil gagal ditambahkan.');
        }
    }

    public function destorySaleDetailBySaleId($saleId)
    {
        try {
            $saleDetail = SaleDetail::where('sale_id', $saleId);
            $saleDetail->delete();

            return $saleDetail;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Penjualan Detil gagal dihapus.');
        }
    }
}
