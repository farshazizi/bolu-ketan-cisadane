<?php

namespace App\Services\Masters\Ingredients;

use App\Repositories\Masters\Ingredients\IngredientRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class IngredientService
{
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function data()
    {
        $ingredients = $this->ingredientRepository->getIngredients();

        return $ingredients;
    }

    public function storeIngredient($data)
    {
        try {
            $ingredient = $this->ingredientRepository->storeIngredient($data);

            return $ingredient;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Bahan berhasil ditambahkan.');
        }
    }

    public function getIngredientById($id)
    {
        $ingredient = $this->ingredientRepository->getIngredientById($id);

        return $ingredient;
    }

    public function updateIngredientById($data, $id)
    {
        try {
            $ingredient = $this->ingredientRepository->updateIngredientById($data, $id);

            return $ingredient;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Bahan berhasil diperbaharui.');
        }
    }

    public function destroyIngredientById($id)
    {
        try {
            $ingredient = $this->ingredientRepository->destroyIngredientById($id);

            return $ingredient;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Bahan berhasil dihapus.');
        }
    }
}
