<?php

namespace App\Models\Masters\Stocks;

use App\Models\Masters\InventoryStocks\InventoryStock;
use App\Models\Masters\Stocks\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockDetail extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function inventoryStock()
    {
        return $this->belongsTo(InventoryStock::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
