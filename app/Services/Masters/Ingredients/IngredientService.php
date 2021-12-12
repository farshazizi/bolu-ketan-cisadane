<?php

namespace App\Services\Masters\Ingredients;

use App\Models\Masters\Ingredients\Ingredient;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        DB::beginTransaction();
        try {
            $uom = new Ingredient;
            $uom->id = Uuid::uuid4();
            $uom->name = $data['name'];
            $uom->uom_id = $data['uom'];
            $uom->save();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Bahan berhasil ditambahkan.');
        }
    }

    public function getIngredientById($id)
    {
        $uom = Ingredient::findOrFail($id);
        return $uom;
    }

    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $uom = Ingredient::findOrFail($id);
            $uom->name = $data['name'];
            $uom->uom_id = $data['uom'];
            $uom->save();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Bahan berhasil diperbaharui.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $uom = Ingredient::findOrFail($id);
            $uom->delete();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Bahan berhasil dihapus.');
        }
    }
}
