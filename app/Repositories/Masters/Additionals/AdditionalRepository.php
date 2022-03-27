<?php

namespace App\Repositories\Masters\Additionals;

use App\Models\Masters\Additionals\Additional;
use App\Repositories\Masters\Additionals\AdditionalInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class AdditionalRepository implements AdditionalInterface
{
    public function getAdditionals()
    {
        $additionals = Additional::all();

        return $additionals;
    }

    public function storeAdditional($data)
    {
        try {
            $additional = new Additional();
            $additional->id = Uuid::uuid4();
            $additional->name = $data['name'];
            $additional->price = $data['price'];
            $additional->save();

            return $additional;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Tambahan berhasil ditambahkan.');
        }
    }

    public function getAdditionalById($id)
    {
        $additional = Additional::findOrFail($id);

        return $additional;
    }

    public function updateAdditionalById($data, $id)
    {
        try {
            $additional = Additional::findOrFail($id);
            $additional->name = $data['name'];
            $additional->price = $data['price'];
            $additional->save();

            return $additional;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Tambahan berhasil diperbaharui.');
        }
    }

    public function destroyAdditionalById($id)
    {
        try {
            $additional = Additional::findOrFail($id);
            $additional->delete();

            return $additional;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Tambahan berhasil dihapus.');
        }
    }
}
