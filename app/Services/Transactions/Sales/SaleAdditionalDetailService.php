<?php

namespace App\Services\Transactions\Sales;

use App\Repositories\Transactions\Sales\SaleAdditionalDetailRepository;

class SaleAdditionalDetailService
{
    private $saleAdditionalDetailRepository;

    public function __construct(SaleAdditionalDetailRepository $saleAdditionalDetailRepository)
    {
        $this->saleAdditionalDetailRepository = $saleAdditionalDetailRepository;
    }

    public function data($saleDetailId)
    {
        $saleAdditionalDetails = $this->saleAdditionalDetailRepository->getSaleAdditionalDetails($saleDetailId);

        if ($saleAdditionalDetails) {
            foreach ($saleAdditionalDetails as $saleAdditionalDetail) {
                $saleAdditionalDetail->price = number_format($saleAdditionalDetail->price, 0);
            }
        }

        return $saleAdditionalDetails;
    }
}