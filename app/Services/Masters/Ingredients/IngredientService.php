<?php

namespace App\Services\Masters\Ingredients;

use App\Models\Masters\Ingredients\Ingredient;
use Ramsey\Uuid\Uuid;

class IngredientService
{
    public function data()
    {
        $data = Ingredient::with('uom')->get();
        return $data;
    }

    public function store($data)
    {
        $uom = new Ingredient;
        $uom->id = Uuid::uuid4();
        $uom->name = $data['name'];
        $uom->uom_id = $data['uom'];
        $uom->save();

        return $uom;
    }

    public function getIngredientById($id)
    {
        $uom = Ingredient::findOrFail($id);
        return $uom;
    }

    public function update($data, $id)
    {
        $uom = Ingredient::findOrFail($id);
        $uom->name = $data['name'];
        $uom->uom_id = $data['uom'];
        $uom->save();

        return $uom;
    }

    public function destroy($id)
    {
        $uom = Ingredient::findOrFail($id);
        $uom->delete();

        return $uom;
    }
}
