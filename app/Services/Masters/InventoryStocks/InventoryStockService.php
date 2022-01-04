<?php

namespace App\Services\Masters\InventoryStocks;

use App\Models\Masters\InventoryStocks\InventoryStock;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class InventoryStockService
{
    public function data()
    {
        $data = InventoryStock::with('category')->get();
        return $data;
    }

    public function store($data)
    {
        try {
            $inventoryStock = new InventoryStock;
            $inventoryStock->id = Uuid::uuid4();
            $inventoryStock->name = $data['name'];
            $inventoryStock->minimal_quantity = parseStringToInteger($data['minimalQuantity']);
            $inventoryStock->price = parseStringToInteger($data['price']);
            $inventoryStock->category_id = $data['category'];
            $inventoryStock->save();

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal ditambahkan.');
        }
    }

    public function getInventoryStockById($id)
    {
        $inventoryStock = InventoryStock::findOrFail($id);
        return $inventoryStock;
    }

    public function update($data, $id)
    {
        try {
            $inventoryStock = InventoryStock::findOrFail($id);
            $inventoryStock->name = $data['name'];
            $inventoryStock->minimal_quantity = parseStringToInteger($data['minimalQuantity']);
            $inventoryStock->price = parseStringToInteger($data['price']);
            $inventoryStock->category_id = $data['category'];
            $inventoryStock->save();

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal diperbaharui.');
        }
    }

    public function destroy($id)
    {
        try {
            $inventoryStock = InventoryStock::findOrFail($id);
            $inventoryStock->delete();

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal dihapus.');
        }
    }
}
