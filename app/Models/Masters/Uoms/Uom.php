<?php

namespace App\Models\Masters\Uoms;

use App\Models\Masters\Ingredients\Ingredient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uom extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
