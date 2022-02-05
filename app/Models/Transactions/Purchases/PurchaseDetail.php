<?php

namespace App\Models\Transactions\Purchases;

use App\Models\Masters\Ingredients\Ingredient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
