<?php

namespace App\Http\Controllers\Transactions\Sales;

use App\Http\Controllers\Controller;
use App\Services\Transactions\Sales\SalePrintService;
use Illuminate\Support\Facades\Response;

class SalePrintController extends Controller
{
    private $salePrintService;

    public function __construct(SalePrintService $salePrintService)
    {
        $this->salePrintService = $salePrintService;
    }

    public function __invoke($id)
    {
        $pdf = $this->salePrintService->print($id);

        $response = Response::make($pdf, 200);
        $response->header('Content-Type', 'application/pdf');

        return $response;
    }
}
