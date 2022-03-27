<?php

namespace App\Http\Controllers\Transactions\Purchases;

use App\Http\Controllers\Controller;
use App\Services\Masters\Ingredients\IngredientService;

class PurchaseUomController extends Controller
{
    private $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function __invoke($id)
    {
        $ingredient = $this->ingredientService->getIngredientById($id);

        return response()->json([
            'status' => 'success',
            'code' => 'get-ingredient-success',
            'message' => 'Get ingredient success.',
            'data' => [
                'ingredient' => $ingredient
            ]
        ], 200);
    }
}
