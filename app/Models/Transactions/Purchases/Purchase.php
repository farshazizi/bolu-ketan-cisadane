<?php

namespace App\Models\Transactions\Purchases;

use App\Models\Transactions\Purchases\PurchaseDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
