<?php

namespace App\Http\Controllers\Transactions\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Orders\StoreOrderRequest;
use App\Services\Masters\Additionals\AdditionalService;
use App\Services\Masters\InventoryStocks\InventoryStockService;
use App\Services\Transactions\Orders\OrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private $additionalService;
    private $inventoryStockService;
    private $orderService;

    public function __construct(AdditionalService $additionalService, InventoryStockService $inventoryStockService, OrderService $orderService)
    {
        $this->additionalService = $additionalService;
        $this->inventoryStockService = $inventoryStockService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        return view('contents.transactions.orders.index');
    }

    public function data()
    {
        $data = $this->orderService->data();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('date', function ($order) {
                $date = Carbon::parse($order->date)->locale('id')->translatedFormat('d-M-Y');
                return $date;
            })
            ->editColumn('grand_total', function ($order) {
                $grandTotal = number_format($order->grand_total, 0);
                return $grandTotal;
            })
            ->addColumn('action', function ($order) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('orders.show', ['id' => $order->id]) . '"><i class="far fa-eye fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $order->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create()
    {
        $additionals = $this->additionalService->data();
        $inventoryStocks = $this->inventoryStockService->data();

        return view('contents.transactions.orders.create', compact('additionals', 'inventoryStocks'));
    }

    public function store(StoreOrderRequest $storeOrderRequest)
    {
        try {
            $request = $storeOrderRequest->safe()->collect();

            $order = $this->orderService->storeOrder($request);

            if ($order) {
                return response()->json([
                    'status' => 'success',
                    'code' => 'store-order-success',
                    'message' => 'Pesanan berhasil ditambahkan.',
                    'data' => [
                        'order' => $order
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'code' => 'store-order-failed',
                'message' => 'Pesanan gagal ditambahkan.',
                'data' => []
            ], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'status' => 'error',
                'code' => 'store-order-failed',
                'message' => 'Pesanan gagal ditambahkan.',
                'data' => []
            ], 500);
        }
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);

        return view('contents.transactions.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        try {
            $order = $this->orderService->destroyInventoryStockById($id);

            if ($order) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Pesanan berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan gagal dihapus.'
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
