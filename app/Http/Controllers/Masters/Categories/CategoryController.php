<?php

namespace App\Http\Controllers\Masters\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Categories\StoreCategoryRequest;
use App\Http\Requests\Masters\Categories\UpdateCategoryRequest;
use App\Services\Masters\Categories\CategoryService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('contents.masters.categories.index');
    }

    public function data()
    {
        $data = $this->categoryService->data();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('categories.edit', ['id' => $category->id]) . '" data-id="' . $category->id . '"><i class="far fa-edit fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $category->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create()
    {
        return view('contents.masters.categories.create');
    }

    public function store(StoreCategoryRequest $storeCategoryRequest)
    {
        DB::beginTransaction();
        try {
            $request = $storeCategoryRequest->safe()->collect();

            $category = $this->categoryService->store($request);

            if ($category) {
                DB::commit();
                return back()->with([
                    'status' => 'success',
                    'message' => 'Kategori berhasil ditambahkan.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Kategori gagal ditambahkan.'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Kategori gagal ditambahkan.'
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return view('contents.masters.categories.edit', compact('id', 'category'));
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Terjadi kendala.'
            ]);
        }
    }

    public function update(UpdateCategoryRequest $updateCategoryRequest, $id)
    {
        DB::beginTransaction();
        try {
            $request = $updateCategoryRequest->safe()->collect();

            $category = $this->categoryService->update($request, $id);

            if ($category) {
                DB::commit();
                return back()->with([
                    'status' => 'success',
                    'message' => 'Kategori berhasil diperbaharui.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Kategori gagal diperbaharui.'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Kategori gagal diperbaharui.'
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryService->destroy($id);

            if ($category) {
                DB::commit();
                return response()->json([
                    'message' => 'Kategori berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'message' => 'Kategori gagal dihapus.'
            ], 500);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
