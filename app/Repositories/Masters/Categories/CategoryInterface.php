<?php

namespace App\Repositories\Masters\Categories;

interface CategoryInterface
{
    public function getCategories();
    public function storeCategory($data);
    public function getCategoryById($id);
    public function updateCategoryById($data, $id);
    public function destroyCategoryById($id);
}
