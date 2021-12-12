<?php

namespace App\Services\Masters\Uoms;

use App\Models\Masters\Uoms\Uom;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UomService
{
    public function data()
    {
        $data = Uom::all();
        return $data;
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $uom = new Uom;
            $uom->id = Uuid::uuid4();
            $uom->name = $data['name'];
            $uom->save();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Satuan gagal ditambahkan.');
        }
    }

    public function getUomById($id)
    {
        $uom = Uom::findOrFail($id);
        return $uom;
    }

    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $uom = Uom::findOrFail($id);
            $uom->name = $data['name'];
            $uom->save();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Satuan gagal diperbaharui.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $uom = Uom::findOrFail($id);
            $uom->delete();
            DB::commit();

            return $uom;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new Exception('Satuan gagal dihapus.');
        }
    }
}
