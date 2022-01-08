<?php

namespace App\Services\Masters\Stocks;

use App\Models\Masters\Stocks\Stock;
use App\Models\Masters\Stocks\StockDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class StockService
{
    public function data()
    {
        $data = Stock::all();
        return $data;
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $stock = new Stock;
            $stockId = Uuid::uuid4();
            $stock->id = $stockId;
            $stock->date = $data['date'];
            $stock->stock_type = $data['stockType'];
            $stock->notes = $data['notes'];
            $stock->save();

            if ($data['inventoryStock']) {
                for ($i = 0; $i < count($data['inventoryStock']); $i++) {
                    $stockDetail = new StockDetail;
                    $stockDetail->id = Uuid::uuid4();
                    $stockDetail->stock_id = $stockId;
                    $stockDetail->inventory_stock_id = $data['inventoryStock'][$i];
                    $stockDetail->quantity = $data['quantity'][$i];
                    $stockDetail->notes = $data['notesDetail'][$i];
                    $stockDetail->save();
                }
            }
            DB::commit();

            return $stock;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Stok masuk gagal ditambahkan.');
        }
    }

    public function getStockById($id)
    {
        $stock = Stock::has('stockDetails')->with('stockDetails.inventoryStock')->findOrFail($id);
        return $stock;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $stockDetail = StockDetail::where('stock_id', $id);
            $stockDetail->delete();

            $stock = Stock::findOrFail($id);
            $stock->delete();
            DB::commit();

            return [
                'stock' => $stock,
                'stockDetail' => $stockDetail,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Stok gagal dihapus.');
        }
    }
}
