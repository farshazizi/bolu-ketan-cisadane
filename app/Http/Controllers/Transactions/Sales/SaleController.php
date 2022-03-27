<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Sales\StoreSaleRequest;
use App\Services\Masters\Additionals\AdditionalService;
use App\Services\Masters\InventoryStocks\InventoryStockService;
use App\Services\Transactions\Orders\OrderService;
use App\Services\Transactions\Sales\SaleService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    private $additionalService;
    private $inventoryStockService;
    private $orderService;
    private $saleService;

    public function __construct(AdditionalService $additionalService, InventoryStockService $inventoryStockService, OrderService $orderService, SaleService $saleService)
    {
        $this->additionalService = $additionalService;
        $this->inventoryStockService = $inventoryStockService;
        $this->orderService = $orderService;
        $this->saleService = $saleService;
    }

    public function index()
    {
        return view('contents.transactions.sales.index');
    }

    public function data()
    {
        $data = $this->saleService->data();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('date', function ($sale) {
                $date = Carbon::parse($sale->date)->locale('id')->translatedFormat('d-M-Y');
                return $date;
            })
            ->editColumn('grand_total', function ($sale) {
                $grandTotal = number_format($sale->grand_total, 0);
                return $grandTotal;
            })
            ->addColumn('action', function ($sale) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('sales.show', ['id' => $sale->id]) . '"><i class="far fa-eye fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $sale->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create($orderId = null)
    {
        $additionals = $this->additionalService->data();
        $inventoryStocks = $this->inventoryStockService->data();

        if ($orderId) {
            $formatting = false;
            $order = $this->orderService->getOrderById($orderId, $formatting);
            $data = [
                'additionals' => $additionals,
                'inventoryStocks' => $inventoryStocks,
                'order' => $order
            ];
        } else {
            $data = [
                'additionals' => $additionals,
                'inventoryStocks' => $inventoryStocks
            ];
        }
        $data = (object) $data;

        return view('contents.transactions.sales.create', compact('data'));
    }

    public function store(StoreSaleRequest $storeSaleRequest)
    {
        try {
            $request = $storeSaleRequest->safe()->collect();

            $sale = $this->saleService->storeSale($request);

            if ($sale) {
                return response()->json([
                    'status' => 'success',
                    'code' => 'store-sale-success',
                    'message' => 'Penjualan berhasil ditambahkan.',
                    'data' => [
                        'sale' => $sale
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'code' => 'store-sale-failed',
                'message' => 'Penjualan gagal ditambahkan.',
                'data' => []
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'code' => 'store-sale-failed',
                'message' => $exception->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function show($id)
    {
        $sale = $this->saleService->getSaleById($id);
        $order = "";
        if ($sale->order_id) {
            $order = $this->orderService->getOrderById($sale->order_id);
        }

        return view('contents.transactions.sales.show', compact('sale', 'order'));
    }

    public function destroy($id)
    {
        try {
            $sale = $this->saleService->destroyInventoryStockById($id);

            if ($sale) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Penjualan berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Penjualan gagal dihapus.'
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
