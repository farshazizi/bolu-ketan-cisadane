<?php

namespace App\Repositories\Transactions\Sales;

use App\Models\Transactions\Sales\Sale;
use App\Models\Transactions\Sales\SaleDetail;
use Carbon\Carbon;
use Exception;
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
        return SaleDetail::where('inventory_stock_id', $id)->sum('quantity');
    }

    public function getSoldQuantities()
    {
        return SaleDetail::groupBy('inventory_stock_id')
            ->selectRaw('inventory_stock_id, SUM(quantity) as total')
            ->pluck('total', 'inventory_stock_id');
    }

    public function getGrandTotalDailySale()
    {
        $grandTotal = Sale::where('date', Carbon::today()->toDateString())->sum('grand_total');

        return $grandTotal;
    }

    public function getLastInvoiceNumberSaleByDate($date)
    {
        $sale = Sale::select('invoice_number')->where('date', $date)->orderByDesc('created_at')->first();

        return $sale;
    }

    public function getSalesByDate($date)
    {
        $sales = Sale::with('saleDetails')->where('date', $date)->orderBy('created_at')->get();

        return $sales;
    }

    public function getSalesByMonth($month)
    {
        // $month is "YYYY-MM"; filter on year too so the same month of other years is excluded
        $date = Carbon::parse($month);
        $sales = Sale::with('saleDetails')
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->orderBy('date')
            ->orderBy('created_at')
            ->get();

        return $sales;
    }
}
