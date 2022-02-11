<?php

namespace App\Http\Controllers\Transactions\Purchases;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Purchases\StorePurchaseRequest;
use App\Services\Masters\Ingredients\IngredientService;
use App\Services\Masters\Uoms\UomService;
use App\Services\Transactions\Purchases\PurchaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    private $ingredientService;
    private $purchaseService;
    private $uomService;

    public function __construct(IngredientService $ingredientService, PurchaseService $purchaseService, UomService $uomService)
    {
        $this->ingredientService = $ingredientService;
        $this->purchaseService = $purchaseService;
        $this->uomService = $uomService;
    }

    public function index()
    {
        return view('contents.transactions.purchases.index');
    }

    public function data()
    {
        $data = $this->purchaseService->data();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('date', function ($purchase) {
                $date = Carbon::parse($purchase->date)->locale('id')->translatedFormat('d-M-Y');
                return $date;
            })
            ->editColumn('grand_total', function ($purchase) {
                $grandTotal = number_format($purchase->grand_total, 0);
                return $grandTotal;
            })
            ->addColumn('action', function ($purchase) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('purchases.show', ['id' => $purchase->id]) . '"><i class="far fa-eye fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $purchase->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create()
    {
        $ingredients = $this->ingredientService->data();
        $uoms = $this->uomService->data();

        return view('contents.transactions.purchases.create', compact('ingredients', 'uoms'));
    }

    public function store(StorePurchaseRequest $storePurchaseRequest)
    {
        try {
            $request = $storePurchaseRequest->safe()->collect();

            $purchase = $this->purchaseService->storePurchase($request);

            if ($purchase) {
                return response()->json([
                    'status' => 'success',
                    'code' => 'store-purchase-success',
                    'message' => 'Pembelian berhasil ditambahkan.',
                    'data' => [
                        'purchase' => $purchase
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'code' => 'store-purchase-failed',
                'message' => 'Pembelian gagal ditambahkan.',
                'data' => []
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'code' => 'store-purchase-failed',
                'message' => 'Pembelian gagal ditambahkan.',
                'data' => []
            ], 500);
        }
    }

    public function show($id)
    {
        $purchase = $this->purchaseService->getPurchaseById($id);

        return view('contents.transactions.purchases.show', compact('purchase'));
    }

    public function destroy($id)
    {
        try {
            $purchase = $this->purchaseService->destroyPurchaseById($id);

            if ($purchase) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Pembelian berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Pembelian gagal dihapus.'
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
