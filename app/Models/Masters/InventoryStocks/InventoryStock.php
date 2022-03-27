<?php

namespace App\Models\Masters\InventoryStocks;

use App\Models\Masters\Categories\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryStock extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
