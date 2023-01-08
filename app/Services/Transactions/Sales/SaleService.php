<?php

namespace App\Services\Transactions\Sales;

use App\Models\Transactions\Sales\Sale;
use App\Repositories\Transactions\Sales\SaleRepository;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class SaleService
{
    private $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function data()
    {
        $sales = $this->saleRepository->getSales();

        return $sales;
    }

    public function storeSale($data)
    {
        try {
            $date = $data['date'];
            $invoiceNumber = $this->generateInvoiceNumber($date);
            $sale = $this->saleRepository->storeSale($data, $invoiceNumber);

            return $sale;
        } catch (Exception $exception) {
            Log::error($exception);
            throw $exception;
        }
    }

    public function getSaleById($id)
    {
        $sale = $this->saleRepository->getSaleById($id);

        if ($sale) {
            $sale->grand_total = number_format($sale->grand_total, 0);
            $saleDetails = $sale->saleDetails;
            for ($index = 0; $index < count($saleDetails); $index++) {
                $saleDetails[$index]->quantity = number_format($saleDetails[$index]->quantity, 0);
                $saleDetails[$index]->price = number_format($saleDetails[$index]->price, 0);
                $saleDetails[$index]->discount = number_format($saleDetails[$index]->discount, 0);
                $saleDetails[$index]->total = number_format($saleDetails[$index]->total, 0);
                $saleDetails[$index]->total_additional = number_format($saleDetails[$index]->total_additional, 0);
            }
        }

        return $sale;
    }

    public function destroyInventoryStockById($id)
    {
        try {
            $sale = $this->saleRepository->destorySaleById($id);

            return $sale;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Penjualan gagal dihapus.');
        }
    }

    public function getGrandTotalDailySale()
    {
        $grandTotal = $this->saleRepository->getGrandTotalDailySale();

        return $grandTotal;
    }

    public function print($id)
    {
        $data = $this->saleRepository->getSaleById($id);

        // Formatting and get time
        if ($data) {
            $data->date = Carbon::parse($data->date)->locale('id')->translatedFormat('d-m-Y');
            $time = Carbon::parse($data->created_at)->locale('id')->translatedFormat('H:i:s');
            $data->time = $time;
        }

        // Get image logo
        $imageLogo = '';
        $rootPathLogo = 'assets/images/logo/';
        $pathLogo = public_path($rootPathLogo . 'Si_Hitam_Manis_Panjang.png');
        if (file_exists($pathLogo)) {
            $imageLogo = base64_encode(file_get_contents($pathLogo));
        }

        // Calculate total discount
        $totalDiscount = 0;
        foreach ($data->saleDetails as $value) {
            $totalDiscount += $value->discount;
        }

        $html = view('contents.pdfs.sale', compact('data', 'imageLogo', 'totalDiscount'))->render();

        $pdf = SnappyPdf::loadHTML($html);
        $pdf->setPaper('a5');
        $pdf->setOrientation('portrait');
        $pdfString = $pdf->output();

        return $pdfString;
    }

    public function generateInvoiceNumber($date)
    {
        try {
            $sale = $this->saleRepository->getLastInvoiceNumber();

            $date = str_replace('-', '', $date);
            $invoiceNumber = '';
            $sequenceNumber = '';

            if ($sale) {
                $lastInvoiceNumber = $sale->invoice_number;
                $lastSequenceNumber = (int) substr($lastInvoiceNumber, -3);
                if ($lastSequenceNumber < 10) {
                    $sequenceNumber = '00' . $lastSequenceNumber + 1;
                } elseif ($lastSequenceNumber < 100) {
                    $sequenceNumber = '0' . $lastSequenceNumber + 1;
                } else {
                    throw new Exception('Nomer Invoice sudah melebihi limit');
                }
            } else {
                $sequenceNumber = '001';
            }

            $invoiceNumber = 'INV' . $date . $sequenceNumber;

            return $invoiceNumber;
        } catch (Exception $exception) {
            Log::error($exception);
            throw $exception;
        }
    }
}
