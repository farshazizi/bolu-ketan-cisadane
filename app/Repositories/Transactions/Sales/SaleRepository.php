<?php

namespace App\Repositories\Transactions\Sales;

use App\Models\Transactions\Sales\Sale;
use App\Models\Transactions\Sales\SaleDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class SaleRepository implements SaleInterface
{
    public function getSales()
    {
        $sales = Sale::orderByDesc('date')->orderByDesc('invoice_number')->get();

        return $sales;
    }

    public function storeSale($data, $invoiceNumber)
    {
        try {
            $sale = new Sale;
            $saleId = Uuid::uuid4();
            $sale->id = $saleId;
            $sale->date = $data['date'];
            $sale->order_id = $data['orderId'];
            $sale->invoice_number = $invoiceNumber;
            $sale->type = $data['orderId'] ? '1' : '0';
            $sale->grand_total = $data['grandTotal'];
            $sale->notes = $data['notes'];
            $sale->save();

            return $sale;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Penjualan gagal ditambahkan.');
        }
    }

    public function getSaleById($id)
    {
        $sale = Sale::has('saleDetails')
            ->with(['saleDetails.inventoryStock', 'saleDetails.saleAdditionalDetails.additional'])
            ->findOrFail($id);

        return $sale;
    }

    public function destorySaleById($id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $sale->delete();

            return $sale;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Penjualan gagal dihapus.');
        }
    }

    public function getStockByInventoryStockId($id)
    {
        $stockDetail = SaleDetail::where('inventory_stock_id', $id)->get();

        return $stockDetail;
    }

    public function getGrandTotalDailySale()
    {
        $grandTotal = Sale::where('date', Carbon::now()->timezone(env('TIMEZONE')))->sum('grand_total');

        return $grandTotal;
    }

    public function getLastInvoiceNumberSaleByDate($date)
    {
        $sale = Sale::select('invoice_number')->where('date', $date)->orderByDesc('created_at')->first();

        return $sale;
    }

    public function getSalesByDate($date)
    {
        $sales = Sale::with('saleDetails.inventoryStock')->where('date', $date)->orderBy('created_at')->get();

        return $sales;
    }

    public function getTotalSalesByDate($date)
    {
        $totalSales = DB::table('sales as s')
            ->join('sale_details as sd', 'sd.sale_id', '=', 's.id')
            ->leftJoin('inventory_stocks as is', 'is.id', '=', 'sd.inventory_stock_id')
            ->groupBy('is.id')
            ->where('s.date', $date)
            ->whereNull('s.deleted_at')
            ->whereNull('sd.deleted_at')
            ->orderBy('is.name')
            ->select('is.id', 'is.name', DB::raw('SUM(sd.quantity) as quantity'))
            ->get();

        return $totalSales;
    }

    public function getSalesByMonth($month)
    {
        $sales = Sale::with('saleDetails.inventoryStock')->whereMonth('date', $month)->orderBy('created_at')->get();

        return $sales;
    }

    public function getTotalSalesByMonth($month)
    {
        $totalSales = DB::table('sales as s')
            ->join('sale_details as sd', 'sd.sale_id', '=', 's.id')
            ->leftJoin('inventory_stocks as is', 'is.id', '=', 'sd.inventory_stock_id')
            ->groupBy('is.id')
            ->whereMonth('s.date', $month)
            ->whereNull('s.deleted_at')
            ->whereNull('sd.deleted_at')
            ->orderBy('is.name')
            ->select('is.id', 'is.name', DB::raw('SUM(sd.quantity) as quantity'))
            ->get();

        return $totalSales;
    }
}
