<?php

namespace App\Services\Masters\Uoms;

use App\Models\Masters\Uoms\Uom;
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
        $uom = new Uom;
        $uom->id = Uuid::uuid4();
        $uom->name = $data['name'];
        $uom->save();

        return $uom;
    }

    public function getUomById($id)
    {
        $uom = Uom::findOrFail($id);
        return $uom;
    }

    public function update($data, $id)
    {
        $uom = Uom::findOrFail($id);
        $uom->name = $data['name'];
        $uom->save();

        return $uom;
    }

    public function destroy($id)
    {
        $uom = Uom::findOrFail($id);
        $uom->delete();

        return $uom;
    }
}
