<?php

namespace App\Services;

use App\Repositories\Contracts\CltLayupRepositoryInterface;

class CltLayupService
{
    protected $cltLayupRepository;

    public function __construct(CltLayupRepositoryInterface $cltLayupRepository)
    {
        $this->cltLayupRepository = $cltLayupRepository;
    }

    public function getLayupsBySupplier($supplierId)
    {
        return $this->cltLayupRepository->allBySupplier($supplierId);
    }

    public function getLayupById($id)
    {
        return $this->cltLayupRepository->find($id);
    }

    public function createLayup(array $data)
    {
        return $this->cltLayupRepository->create($data);
    }

    public function updateLayup($id, array $data)
    {
        return $this->cltLayupRepository->update($id, $data);
    }

    public function deleteLayup($id)
    {
        return $this->cltLayupRepository->delete($id);
    }
}
