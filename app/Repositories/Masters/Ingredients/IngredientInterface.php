<?php

namespace App\Repositories\Masters\Ingredients;

interface IngredientInterface
{
    public function getIngredients();
    public function storeIngredient($data);
    public function getIngredientById($id);
    public function updateIngredientById($data, $id);
    public function destroyIngredientById($id);
}