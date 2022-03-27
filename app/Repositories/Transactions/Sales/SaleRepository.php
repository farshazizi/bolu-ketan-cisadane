<?php

namespace App\Repositories\Transactions\Sales;

use App\Models\Transactions\Orders\Order;
use App\Models\Transactions\Sales\Sale;
use App\Models\Transactions\Sales\SaleAdditionalDetail;
use App\Models\Transactions\Sales\SaleDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class SaleRepository implements SaleInterface
{
    public function getSales()
    {
        $sales = Sale::all();

        return $sales;
    }

    public function storeSale($data, $invoiceNumber)
    {
        DB::beginTransaction();
        try {
            $sale = new Sale;
            $saleId = Uuid::uuid4();
            $sale->id = $saleId;
            $sale->date = $data['date'];
            $sale->order_id = $data['orderId'];
            $sale->invoice_number = $invoiceNumber;
            $sale->type = $data['orderId'] ? '1' : '0';
            $sale->grand_total = $data['grandTotal'];
            $sale->notes = $data['notes'];
            $sale->save();

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
                    $saleDetail->notes = $data['detail'][$index]['notes'];
                    $saleDetail->save();

                    if ($data['detailAdditional']) {
                        for ($indexAdditional = 0; $indexAdditional < count($data['detailAdditional']); $indexAdditional++) {
                            if ($data['detailAdditional'][$indexAdditional]['index'] == $index) {
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

            if ($data['orderId']) {
                Order::where('id', $data['orderId'])->update(['status' => 1]);
            }
            DB::commit();

            return $sale;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Penjualan gagal ditambahkan.');
        }
    }

    public function getSaleById($id)
    {
        $sale = Sale::has('saleDetails')
            ->with(['saleDetails.inventoryStock', 'saleDetails.saleAdditionalDetails.additional'])
            ->findOrFail($id);

        return $sale;
    }

    public function destorySaleById($id)
    {
        DB::beginTransaction();
        try {
            // Delete sale additional detail
            $saleDetail = SaleDetail::where('sale_id', $id)->first();
            $saleDetailId = $saleDetail->id;
            $saleAdditionalDetail = SaleAdditionalDetail::where('sale_detail_id', $saleDetailId);
            $saleAdditionalDetail->delete();

            // Delete sale detail
            $saleDetail = SaleDetail::where('sale_id', $id);
            $saleDetail->delete();

            // Delete sale
            $sale = Sale::findOrFail($id);
            $sale->delete();
            DB::commit();

            return [
                'sale' => $sale,
                'saleDetail' => $saleDetail,
                'saleAdditionalDetail' => $saleAdditionalDetail,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Penjualan gagal dihapus.');
        }
    }

    public function getStockByInventoryStockId($id)
    {
        $stockDetail = SaleDetail::where('inventory_stock_id', $id)->get();

        return $stockDetail;
    }

    public function getGrandTotalDailySale()
    {
        $grandTotal = Sale::sum('grand_total');

        return $grandTotal;
    }

    public function getInvoiceNumbers()
    {
        $invoiceNumbers = Sale::select('invoice_number')->orderBy('invoice_number', 'desc')->get();

        return $invoiceNumbers;
    }
}
