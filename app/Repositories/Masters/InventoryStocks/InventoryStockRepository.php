<?php

namespace App\Repositories\Masters\InventoryStocks;

use App\Models\Masters\InventoryStocks\InventoryStock;
use Ramsey\Uuid\Uuid;

class InventoryStockRepository implements InventoryStockInterface
{
    public function getInventoryStocks()
    {
        $inventoryStocks = InventoryStock::with('category')->get();

        return $inventoryStocks;
    }

    public function storeInventoryStock($data)
    {
        $inventoryStock = new InventoryStock;
        $inventoryStock->id = Uuid::uuid4();
        $inventoryStock->name = $data['name'];
        $inventoryStock->minimal_quantity = parseStringToInteger($data['minimalQuantity']);
        $inventoryStock->price = parseStringToInteger($data['price']);
        $inventoryStock->category_id = $data['category'];
        $inventoryStock->save();

        return $inventoryStock;
    }

    public function getInventoryStockById($id)
    {
        $inventoryStock = InventoryStock::findOrFail($id);

        return $inventoryStock;
    }

    public function updateInventoryStockById($data, $id)
    {
        $inventoryStock = InventoryStock::findOrFail($id);
        $inventoryStock->name = $data['name'];
        $inventoryStock->minimal_quantity = parseStringToInteger($data['minimalQuantity']);
        $inventoryStock->price = parseStringToInteger($data['price']);
        $inventoryStock->category_id = $data['category'];
        $inventoryStock->save();

        return $inventoryStock;
    }

    public function destoryInventoryStockById($id)
    {
        $inventoryStock = InventoryStock::findOrFail($id);
        $inventoryStock->delete();

        return $inventoryStock;
    }

    public function getPriceById($id)
    {
        $price = InventoryStock::select('price')->findOrFail($id);

        return $price;
    }
}
