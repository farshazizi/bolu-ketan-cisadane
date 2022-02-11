<?php

namespace App\Repositories\Masters\Additionals;

interface AdditionalInterface
{
    public function getAdditionals();
    public function storeAdditional($data);
    public function getAdditionalById($id);
    public function updateAdditionalById($data, $id);
    public function destroyAdditionalById($id);
}
