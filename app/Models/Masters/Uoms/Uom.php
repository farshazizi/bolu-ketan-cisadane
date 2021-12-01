<?php

namespace App\Models\Masters\Uoms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uom extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
}
