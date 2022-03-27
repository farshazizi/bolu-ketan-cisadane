<?php

namespace App\Http\Controllers\Masters\Ingredients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Ingredients\StoreIngredientRequest;
use App\Http\Requests\Masters\Ingredients\UpdateIngredientRequest;
use App\Services\Masters\Ingredients\IngredientService;
use App\Services\Masters\Uoms\UomService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IngredientController extends Controller
{
    private $ingredientService;
    private $uomService;

    public function __construct(IngredientService $ingredientService, UomService $uomService)
    {
        $this->ingredientService = $ingredientService;
        $this->uomService = $uomService;
    }

    public function index()
    {
        return view('contents.masters.ingredients.index');
    }

    public function data()
    {
        $data = $this->ingredientService->data();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($ingredient) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('ingredients.edit', ['id' => $ingredient->id]) . '" data-id="' . $ingredient->id . '"><i class="far fa-edit fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $ingredient->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create()
    {
        $uoms = $this->uomService->data();
        return view('contents.masters.ingredients.create', compact('uoms'));
    }

    public function store(StoreIngredientRequest $storeIngredientRequest)
    {
        try {
            $request = $storeIngredientRequest->safe()->collect();

            $ingredient = $this->ingredientService->store($request);

            if ($ingredient) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Bahan berhasil ditambahkan.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Bahan gagal ditambahkan.'
            ])->withInput();
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Bahan gagal ditambahkan.'
            ])->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $ingredient = $this->ingredientService->getIngredientById($id);
            $uoms = $this->uomService->data();
            return view('contents.masters.ingredients.edit', compact('id', 'ingredient', 'uoms'));
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Terjadi kendala.'
            ]);
        }
    }

    public function update(UpdateIngredientRequest $updateIngredientRequest, $id)
    {
        try {
            $request = $updateIngredientRequest->safe()->collect();

            $ingredient = $this->ingredientService->update($request, $id);

            if ($ingredient) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Bahan berhasil diperbaharui.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Bahan gagal diperbaharui.'
            ])->withInput();
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Bahan gagal diperbaharui.'
            ])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $ingredient = $this->ingredientService->destroy($id);

            if ($ingredient) {
                return response()->json([
                    'message' => 'Bahan berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'message' => 'Bahan gagal dihapus.'
            ], 500);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
