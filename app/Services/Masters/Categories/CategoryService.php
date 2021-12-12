<?php

namespace App\Services\Masters\Categories;

use App\Models\Masters\Categories\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        DB::beginTransaction();
        try {
            $uom = new Category;
            $uom->id = Uuid::uuid4();
            $uom->name = $data['name'];
            $uom->save();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Kategori gagal ditambahkan.');
        }
    }

    public function getCategoryById($id)
    {
        $uom = Category::findOrFail($id);
        return $uom;
    }

    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $uom = Category::findOrFail($id);
            $uom->name = $data['name'];
            $uom->save();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Kategori gagal dirubah.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $uom = Category::findOrFail($id);
            $uom->delete();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Kategori gagal dihapus.');
        }
    }
}
