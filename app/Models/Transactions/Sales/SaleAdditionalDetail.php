<?php

namespace App\Models\Transactions\Sales;

use App\Models\Masters\Additionals\Additional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleAdditionalDetail extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function additional()
    {
        return $this->belongsTo(Additional::class);
    }
}
