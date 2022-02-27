<?php

namespace App\Repositories\Transactions\Sales;

use App\Models\Transactions\Sales\Sale;
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

    public function storeSale($data)
    {
        DB::beginTransaction();
        try {
            $sale = new Sale;
            $saleId = Uuid::uuid4();
            $sale->id = $saleId;
            $sale->date = $data['date'];
            $sale->grand_total = $data['grandTotal'];
            $sale->notes = $data['notes'];
            $sale->save();

            if ($data['detail']) {
                for ($index = 0; $index < count($data['detail']); $index++) {
                    $saleDetail = new SaleDetail;
                    $saleDetail->id = Uuid::uuid4();
                    $saleDetail->sale_id = $saleId;
                    $saleDetail->inventory_stock_id = $data['detail'][$index]['inventoryStock'];
                    $saleDetail->quantity = $data['detail'][$index]['quantity'];
                    $saleDetail->price = $data['detail'][$index]['price'];
                    $saleDetail->discount = $data['detail'][$index]['discount'];
                    $saleDetail->total = $data['detail'][$index]['total'];
                    $saleDetail->notes = $data['detail'][$index]['notes'];
                    $saleDetail->save();
                }
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
        $sale = Sale::has('saleDetails')->with('saleDetails.inventoryStock')->findOrFail($id);

        return $sale;
    }

    public function destorySaleById($id)
    {
        DB::beginTransaction();
        try {
            $saleDetail = SaleDetail::where('sale_id', $id);
            $saleDetail->delete();

            $sale = Sale::findOrFail($id);
            $sale->delete();
            DB::commit();

            return [
                'sale' => $sale,
                'saleDetail' => $saleDetail,
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
}
