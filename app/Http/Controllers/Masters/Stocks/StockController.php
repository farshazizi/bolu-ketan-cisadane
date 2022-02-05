<?php

namespace App\Http\Controllers\Masters\Stocks;

use App\Http\Controllers\Controller;
use App\Services\Masters\Stocks\StockService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        return view('contents.masters.stocks.index');
    }

    public function data()
    {
        $data = $this->stockService->data();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('date', function ($stock) {
                $date = Carbon::parse($stock->date)->locale('id')->translatedFormat('d-M-Y');
                return $date;
            })
            ->editColumn('stock_type', function ($stock) {
                $stockType = '';
                if ($stock->stock_type == 0) {
                    $stockType = 'Stok Masuk';
                } elseif ($stock->stock_type == 1) {
                    $stockType = 'Stok Keluar';
                }
                return $stockType;
            })
            ->addColumn('action', function ($stock) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('stocks.show', ['id' => $stock->id]) . '"><i class="far fa-eye fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $stock->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function show($id)
    {
        $stock = $this->stockService->getStockById($id);

        return view('contents.masters.stocks.show', compact('stock'));
    }

    public function destroy($id)
    {
        try {
            $stock = $this->stockService->destroy($id);

            if ($stock) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Stok berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Stok gagal dihapus.'
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
