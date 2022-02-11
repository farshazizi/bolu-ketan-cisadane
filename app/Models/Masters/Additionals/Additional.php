<?php

namespace App\Models\Masters\Additionals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Additional extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
}
