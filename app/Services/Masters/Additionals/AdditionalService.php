<?php

namespace App\Services\Masters\Additionals;

use App\Repositories\Masters\Additionals\AdditionalRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class AdditionalService
{
    private $additionalRepository;

    public function __construct(AdditionalRepository $additionalRepository)
    {
        $this->additionalRepository = $additionalRepository;
    }

    public function data()
    {
        $additionals = $this->additionalRepository->getAdditionals();

        return $additionals;
    }

    public function storeAdditional($data)
    {
        try {
            $additional = $this->additionalRepository->storeAdditional($data);

            return $additional;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Tambahan berhasil ditambahkan.');
        }
    }

    public function getAdditionalById($id)
    {
        $additional = $this->additionalRepository->getAdditionalById($id);

        return $additional;
    }

    public function updateAdditionalById($data, $id)
    {
        try {
            $additional = $this->additionalRepository->updateAdditionalById($data, $id);

            return $additional;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Tambahan berhasil diperbaharui.');
        }
    }

    public function destroyAdditionalById($id)
    {
        try {
            $additional = $this->additionalRepository->destroyAdditionalById($id);

            return $additional;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Tambahan berhasil dihapus.');
        }
    }
}
