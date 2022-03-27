<?php

namespace App\Models\Transactions\Orders;

use App\Models\Transactions\Orders\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
