<?php

namespace App\Repositories\Masters\Ingredients;

use App\Models\Masters\Ingredients\Ingredient;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class IngredientRepository implements IngredientInterface
{
    public function getIngredients()
    {
        $ingredients = Ingredient::with('uom')->get();

        return $ingredients;
    }

    public function storeIngredient($data)
    {
        try {
            $ingredient = new Ingredient;
            $ingredient->id = Uuid::uuid4();
            $ingredient->name = $data['name'];
            $ingredient->uom_id = $data['uom'];
            $ingredient->save();

            return $ingredient;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Bahan berhasil ditambahkan.');
        }
    }

    public function getIngredientById($id)
    {
        $ingredient = Ingredient::with('uom')->findOrFail($id);

        return $ingredient;
    }

    public function updateIngredientById($data, $id)
    {
        try {
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->name = $data['name'];
            $ingredient->uom_id = $data['uom'];
            $ingredient->save();

            return $ingredient;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Bahan berhasil diperbaharui.');
        }
    }

    public function destroyIngredientById($id)
    {
        try {
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->delete();

            return $ingredient;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Bahan berhasil dihapus.');
        }
    }
}