<?php

namespace App\Services\Transactions\Sales;

use App\Repositories\Transactions\Orders\OrderRepository;
use App\Repositories\Transactions\Sales\SaleAdditionalDetailRepository;
use App\Repositories\Transactions\Sales\SaleDetailRepository;
use App\Repositories\Transactions\Sales\SaleRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleService
{
    private $orderRepository;
    private $saleAdditionalDetailRepository;
    private $saleDetailRepository;
    private $saleRepository;

    public function __construct(OrderRepository $orderRepository, SaleAdditionalDetailRepository $saleAdditionalDetailRepository, SaleDetailRepository $saleDetailRepository, SaleRepository $saleRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->saleAdditionalDetailRepository = $saleAdditionalDetailRepository;
        $this->saleDetailRepository = $saleDetailRepository;
        $this->saleRepository = $saleRepository;
    }

    public function data()
    {
        $sales = $this->saleRepository->getSales();

        return $sales;
    }

    public function storeSale($data)
    {
        DB::beginTransaction();
        try {
            $invoiceNumber = $this->generateInvoiceNumber($data['date']);

            // Add Sale
            $sale = $this->saleRepository->storeSale($data, $invoiceNumber);

            // Add Sale Detail (include Sale Additional Detail)
            $this->saleDetailRepository->storeSaleDetail($data, $sale->id);

            // Update Status Order
            if ($data['orderId']) {
                $this->orderRepository->setOrderStatusSuccessById($data['orderId']);
            }

            DB::commit();

            return $sale;
        } catch (Exception $exception) {
            DB::rollBack();
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

    public function destroySale($id)
    {
        DB::beginTransaction();
        try {
            // Delete Sale Additional Detail
            $this->saleAdditionalDetailRepository->destorySaleAdditionalDetailsBySaleId($id);

            // Delete Sale Detail
            $this->saleDetailRepository->destorySaleDetailBySaleId($id);

            // Delete Sale
            $sale = $this->saleRepository->destorySaleById($id);

            // Update Status Order
            if ($sale->type == "1") {
                $this->orderRepository->setOrderStatusFailedById($sale->order_id);
            }

            DB::commit();

            return $sale;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw $exception;
        }
    }

    public function getGrandTotalDailySale()
    {
        $grandTotal = $this->saleRepository->getGrandTotalDailySale();

        return $grandTotal;
    }

    public function generateInvoiceNumber($date)
    {
        try {
            $sale = $this->saleRepository->getLastInvoiceNumberSaleByDate($date);

            $date = str_replace('-', '', $date);
            $invoiceNumber = '';
            $sequenceNumber = '';

            if ($sale) {
                $lastInvoiceNumber = $sale->invoice_number;
                $lastSequenceNumber = (int) substr($lastInvoiceNumber, -5);
                $newSequenceNumber = $lastSequenceNumber + 1;
                if ($lastSequenceNumber < 10) {
                    $sequenceNumber = '0000' . $newSequenceNumber;
                } elseif ($lastSequenceNumber < 100) {
                    $sequenceNumber = '000' . $newSequenceNumber;
                } elseif ($lastSequenceNumber < 1000) {
                    $sequenceNumber = '00' . $newSequenceNumber;
                } elseif ($lastSequenceNumber < 10000) {
                    $sequenceNumber = '0' . $newSequenceNumber;
                } else {
                    throw new Exception('Nomer Invoice sudah melebihi limit');
                }
            } else {
                $sequenceNumber = '00001';
            }

            $invoiceNumber = 'INV' . $date . $sequenceNumber;

            return $invoiceNumber;
        } catch (Exception $exception) {
            Log::error($exception);
            throw $exception;
        }
    }
}
