<?php

namespace App\Services;

use App\Repositories\Contracts\SupplierRepositoryInterface;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAllSuppliers()
    {
        return $this->supplierRepository->all();
    }

    public function getPaginatedSuppliers($perPage = 10)
    {
        return $this->supplierRepository->paginate($perPage);
    }

    public function getSupplierById($id)
    {
        return $this->supplierRepository->find($id);
    }

    public function getSupplierByExtId($extId)
    {
        return $this->supplierRepository->findByExtId($extId);
    }

    public function createSupplier(array $data)
    {
        return $this->supplierRepository->create($data);
    }

    public function updateSupplier($id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function deleteSupplier($id)
    {
        return $this->supplierRepository->delete($id);
    }
}
