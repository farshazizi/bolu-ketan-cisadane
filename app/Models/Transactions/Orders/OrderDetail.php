<?php

namespace App\Models\Transactions\Orders;

use App\Models\Masters\InventoryStocks\InventoryStock;
use App\Models\Transactions\Orders\OrderAdditionalDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function inventoryStock()
    {
        return $this->belongsTo(InventoryStock::class);
    }

    public function orderAdditionalDetails()
    {
        return $this->hasMany(OrderAdditionalDetail::class);
    }
}
