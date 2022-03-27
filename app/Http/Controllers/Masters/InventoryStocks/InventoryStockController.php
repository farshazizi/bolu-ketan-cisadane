<?php

namespace App\Http\Controllers\Masters\InventoryStocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\InventoryStocks\StoreInventoryStockRequest;
use App\Http\Requests\Masters\InventoryStocks\UpdateInventoryStockRequest;
use App\Services\Masters\Categories\CategoryService;
use App\Services\Masters\InventoryStocks\InventoryStockService;
use Exception;
use Illuminate\Support\Facades\Log;

class InventoryStockController extends Controller
{
    private $categoryService;
    private $inventoryStockService;

    public function __construct(CategoryService $categoryService, InventoryStockService $inventoryStockService)
    {
        $this->categoryService = $categoryService;
        $this->inventoryStockService = $inventoryStockService;
    }

    public function index()
    {
        return view('contents.masters.inventory-stocks.index');
    }

    public function data()
    {
        $data = $this->inventoryStockService->data();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('minimal_quantity', function ($inventoryStock) {
                $minimalQuantity = number_format($inventoryStock->minimal_quantity, 0);
                return $minimalQuantity;
            })
            ->editColumn('price', function ($inventoryStock) {
                $price = number_format($inventoryStock->price, 0);
                return $price;
            })
            ->addColumn('action', function ($inventoryStock) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('inventory_stocks.edit', ['id' => $inventoryStock->id]) . '" data-id="' . $inventoryStock->id . '"><i class="far fa-edit fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $inventoryStock->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create()
    {
        $categories = $this->categoryService->data();

        return view('contents.masters.inventory-stocks.create', compact('categories'));
    }

    public function store(StoreInventoryStockRequest $storeInventoryStockRequest)
    {
        try {
            $request = $storeInventoryStockRequest->safe()->collect();

            $inventoryStock = $this->inventoryStockService->storeInventoryStock($request);

            if ($inventoryStock) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Stok berhasil ditambahkan.'
                ]);
            }

            return back()->with([
                'status' => 'danger',
                'message' => 'Stok gagal ditambahkan.'
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'danger',
                'message' => 'Stok gagal ditambahkan.'
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $categories = $this->categoryService->data();
            $inventoryStock = $this->inventoryStockService->getInventoryStockById($id);

            return view('contents.masters.inventory-stocks.edit', compact('categories', 'id', 'inventoryStock'));
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'danger',
                'message' => 'Terjadi kendala menampilkan data.'
            ]);
        }
    }

    public function update(UpdateInventoryStockRequest $updateInventoryStockRequest, $id)
    {
        try {
            $request = $updateInventoryStockRequest->safe()->collect();

            $inventoryStock = $this->inventoryStockService->updateInventoryStockById($request, $id);

            if ($inventoryStock) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Stok berhasil diperbaharui.'
                ]);
            }

            return back()->with([
                'status' => 'danger',
                'message' => 'Stok gagal diperbaharui.'
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'danger',
                'message' => 'Stok gagal diperbaharui.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $inventoryStock = $this->inventoryStockService->destroyInventoryStockById($id);

            if ($inventoryStock) {
                return response()->json([
                    'message' => 'Stok berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'message' => 'Stok gagal dihapus.'
            ], 500);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
