<?php

namespace App\Services;

use App\Repositories\Contracts\CltLayerRepositoryInterface;

class CltLayerService
{
    protected $cltLayerRepository;

    public function __construct(CltLayerRepositoryInterface $cltLayerRepository)
    {
        $this->cltLayerRepository = $cltLayerRepository;
    }

    public function getLayersByLayup($layupId)
    {
        return $this->cltLayerRepository->allByLayup($layupId);
    }

    public function getLayerById($id)
    {
        return $this->cltLayerRepository->find($id);
    }

    public function createLayer(array $data)
    {
        return $this->cltLayerRepository->create($data);
    }

    public function updateLayer($id, array $data)
    {
        return $this->cltLayerRepository->update($id, $data);
    }

    public function deleteLayer($id)
    {
        return $this->cltLayerRepository->delete($id);
    }
}
