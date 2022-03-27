<?php

namespace App\Services\Masters\Uoms;

use App\Repositories\Masters\Uoms\UomRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class UomService
{
    private $uomRepository;

    public function __construct(UomRepository $uomRepository)
    {
        $this->uomRepository = $uomRepository;
    }

    public function data()
    {
        $uoms = $this->uomRepository->getUoms();

        return $uoms;
    }

    public function storeUom($data)
    {
        try {
            $uom = $this->uomRepository->storeUom($data);

            return $uom;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Satuan gagal ditambahkan.');
        }
    }

    public function getUomById($id)
    {
        $uom = $this->uomRepository->getUomById($id);

        return $uom;
    }

    public function updateUomById($data, $id)
    {
        try {
            $uom = $this->uomRepository->updateUomById($data, $id);

            return $uom;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Satuan gagal diperbaharui.');
        }
    }

    public function destroyUomById($id)
    {
        try {
            $uom = $this->uomRepository->destroyUomById($id);

            return $uom;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Satuan gagal dihapus.');
        }
    }
}
