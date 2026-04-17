<?php

namespace App\Repositories\Eloquent;

use App\Models\CltLayup;
use App\Repositories\Contracts\CltLayupRepositoryInterface;

class CltLayupRepository implements CltLayupRepositoryInterface
{
    public function allBySupplier($supplierId)
    {
        return CltLayup::where('supplier_id', $supplierId)->get();
    }

    public function find($id)
    {
        return CltLayup::findOrFail($id);
    }

    public function findByNameAndSupplier($name, $supplierId)
    {
        return CltLayup::where('name', $name)->where('supplier_id', $supplierId)->first();
    }

    public function create(array $data)
    {
        return CltLayup::create($data);
    }

    public function update($id, array $data)
    {
        $layup = CltLayup::findOrFail($id);
        $layup->update($data);
        return $layup;
    }

    public function delete($id)
    {
        $layup = CltLayup::findOrFail($id);
        return $layup->delete();
    }
}
