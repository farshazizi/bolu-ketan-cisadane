<?php

namespace App\Repositories\Masters\Stocks;

use App\Models\Masters\Stocks\Stock;
use App\Models\Masters\Stocks\StockDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class StockRepository implements StockInterface
{
    public function getStocks()
    {
        $stocks = Stock::all();

        return $stocks;
    }

    public function storeStock($data)
    {
        DB::beginTransaction();
        try {
            $stock = new Stock();
            $stockId = Uuid::uuid4();
            $stock->id = $stockId;
            $stock->date = $data['date'];
            $stock->stock_type = $data['stockType'];
            $stock->notes = $data['notes'];
            $stock->save();

            if ($data['detail']) {
                for ($index = 0; $index < count($data['detail']); $index++) {
                    $stockDetail = new StockDetail();
                    $stockDetail->id = Uuid::uuid4();
                    $stockDetail->stock_id = $stockId;
                    $stockDetail->inventory_stock_id = $data['detail'][$index]['inventoryStock'];
                    $stockDetail->quantity = $data['detail'][$index]['quantity'];
                    $stockDetail->notes = $data['detail'][$index]['notes'];
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

    public function destoryStockById($id)
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

    public function getStockInByInventoryStockId($id)
    {
        return $this->stockDetailsByType(0)->where('inventory_stock_id', $id)->sum('quantity');
    }

    public function getStockOutByInventoryStockId($id)
    {
        return $this->stockDetailsByType(1)->where('inventory_stock_id', $id)->sum('quantity');
    }

    public function getStockInQuantities()
    {
        return $this->sumQuantityPerInventoryStock($this->stockDetailsByType(0));
    }

    public function getStockOutQuantities()
    {
        return $this->sumQuantityPerInventoryStock($this->stockDetailsByType(1));
    }

    private function stockDetailsByType($stockType)
    {
        return StockDetail::whereHas('stock', function ($query) use ($stockType) {
            $query->where('stock_type', $stockType);
        });
    }

    private function sumQuantityPerInventoryStock($query)
    {
        return $query->groupBy('inventory_stock_id')
            ->selectRaw('inventory_stock_id, SUM(quantity) as total')
            ->pluck('total', 'inventory_stock_id');
    }
}
