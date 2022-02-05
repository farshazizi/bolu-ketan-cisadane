<?php

namespace App\Models\Transactions\Sales;

use App\Models\Transactions\Sales\SaleDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
