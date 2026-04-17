<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function all()
    {
        return Supplier::all();
    }

    public function find($id)
    {
        return Supplier::findOrFail($id);
    }

    public function findByExtId($extId)
    {
        return Supplier::where('ext_id', $extId)->firstOrFail();
    }

    public function create(array $data)
    {
        return Supplier::create($data);
    }

    public function update($id, array $data)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        return $supplier->delete();
    }
}
