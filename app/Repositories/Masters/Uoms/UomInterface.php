<?php

namespace App\Repositories\Masters\Uoms;

interface UomInterface
{
    public function getUoms();
    public function storeUom($data);
    public function getUomById($id);
    public function updateUomById($data, $id);
    public function destroyUomById($id);
}