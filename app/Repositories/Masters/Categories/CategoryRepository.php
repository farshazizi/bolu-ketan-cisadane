<?php

namespace App\Repositories\Masters\Categories;

use App\Models\Masters\Categories\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class CategoryRepository implements CategoryInterface
{
    public function getCategories()
    {
        $categories = Category::all();

        return $categories;
    }

    public function storeCategory($data)
    {
        DB::beginTransaction();
        try {
            $category = new Category;
            $categoryId = Uuid::uuid4();
            $category->id = $categoryId;
            $category->name = $data['name'];
            $category->save();
            DB::commit();

            return $category;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Kategori gagal ditambahkan.');
        }
    }

    public function getCategoryById($id)
    {
        $category = Category::findOrFail($id);

        return $category;
    }

    public function updateCategoryById($data, $id)
    {
        DB::beginTransaction();
        try {
            $category = Category::findOrFail($id);
            $category->name = $data['name'];
            $category->save();
            DB::commit();

            return $category;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Kategori gagal diperbaharui.');
        }
    }

    public function destroyCategoryById($id)
    {
        DB::beginTransaction();
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            DB::commit();

            return $category;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Kategori gagal dihapus.');
        }
    }
}
