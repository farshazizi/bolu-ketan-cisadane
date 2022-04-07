<?php

namespace App\Services\Masters\Categories;

use App\Repositories\Masters\Categories\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function data()
    {
        $categories = $this->categoryRepository->getCategories();

        return $categories;
    }

    public function store($data)
    {
        try {
            $category = $this->categoryRepository->storeCategory($data);

            return $category;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Kategori berhasil ditambahkan.');
        }
    }

    public function getCategoryById($id)
    {
        $category = $this->categoryRepository->getCategoryById($id);

        return $category;
    }

    public function update($data, $id)
    {
        try {
            $category = $this->categoryRepository->updateCategoryById($data, $id);

            return $category;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Kategori berhasil diperbaharui.');
        }
    }

    public function destroy($id)
    {
        try {
            $category = $this->categoryRepository->destroyCategoryById($id);

            return $category;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Kategori berhasil dihapus.');
        }
    }
}
