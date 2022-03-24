<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Services\Transactions\Sales\SaleService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class SalePrintController extends Controller
{
    private $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function __invoke($id)
    {
        try {
            $pdf = $this->saleService->print($id);

            $response = Response::make($pdf, 200);
            $response->header('Content-Type', 'application/pdf');

            return $response;
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }
}
