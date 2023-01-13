<?php

namespace App\Services\Transactions\Sales;

use App\Repositories\Transactions\Sales\SaleRepository;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;

class SalePrintService
{
    private $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
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
}
