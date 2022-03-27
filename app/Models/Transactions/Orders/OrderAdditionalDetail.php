<?php

namespace App\Models\Transactions\Orders;

use App\Models\Masters\Additionals\Additional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAdditionalDetail extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function additional()
    {
        return $this->belongsTo(Additional::class);
    }
}
