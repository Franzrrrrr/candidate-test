<?php

namespace App\Repositories\Contracts;

interface CltLayerRepositoryInterface
{
    public function allByLayup($layupId);
    public function find($id);
    public function findByOrderAndLayup($order, $layupId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function deleteByLayup($layupId);
}
