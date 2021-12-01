<?php

namespace App\Services\Masters\Categories;

use App\Models\Masters\Categories\Category;
use Ramsey\Uuid\Uuid;

class CategoryService
{
    public function data()
    {
        $data = Category::all();
        return $data;
    }

    public function store($data)
    {
        $uom = new Category;
        $uom->id = Uuid::uuid4();
        $uom->name = $data['name'];
        $uom->save();

        return $uom;
    }

    public function getCategoryById($id)
    {
        $uom = Category::findOrFail($id);
        return $uom;
    }

    public function update($data, $id)
    {
        $uom = Category::findOrFail($id);
        $uom->name = $data['name'];
        $uom->save();

        return $uom;
    }

    public function destroy($id)
    {
        $uom = Category::findOrFail($id);
        $uom->delete();

        return $uom;
    }
}
