<?php

namespace App\Models\Masters\Ingredients;

use App\Models\Masters\Uoms\Uom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }
}
