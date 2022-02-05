<?php

namespace App\Repositories\Masters\Uoms;

use App\Models\Masters\Uoms\Uom;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UomRepository implements UomInterface
{
    public function getUoms()
    {
        $uoms = Uom::all();

        return $uoms;
    }

    public function storeUom($data)
    {
        try {
            $uom = new Uom;
            $uom->id = Uuid::uuid4();
            $uom->name = $data['name'];
            $uom->save();

            return $uom;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Satuan gagal ditambahkan.');
        }
    }

    public function getUomById($id)
    {
        $uom = Uom::findOrFail($id);

        return $uom;
    }

    public function updateUomById($data, $id)
    {
        try {
            $uom = Uom::findOrFail($id);
            $uom->name = $data['name'];
            $uom->save();

            return $uom;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Satuan gagal diperbaharui.');
        }
    }

    public function destroyUomById($id)
    {
        try {
            $uom = Uom::findOrFail($id);
            $uom->delete();

            return $uom;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Bahan berhasil dihapus.');
        }
    }
}
