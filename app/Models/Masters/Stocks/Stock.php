<?php

namespace App\Models\Masters\Stocks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function stockDetails()
    {
        return $this->hasMany(StockDetail::class);
    }
}
