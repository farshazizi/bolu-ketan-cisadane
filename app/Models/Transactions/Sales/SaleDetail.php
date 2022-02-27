<?php

namespace App\Models\Transactions\Sales;

use App\Models\Masters\InventoryStocks\InventoryStock;
use App\Models\Transactions\Sales\SaleAdditionalDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function inventoryStock()
    {
        return $this->belongsTo(InventoryStock::class);
    }

    public function saleAdditionalDetails()
    {
        return $this->hasMany(SaleAdditionalDetail::class);
    }
}
