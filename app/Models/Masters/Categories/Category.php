<?php

namespace App\Models\Masters\Categories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
}
