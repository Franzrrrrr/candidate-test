<?php

namespace App\Repositories\Eloquent;

use App\Models\CltLayer;
use App\Repositories\Contracts\CltLayerRepositoryInterface;

class CltLayerRepository implements CltLayerRepositoryInterface
{
    public function allByLayup($layupId)
    {
        return CltLayer::where('layup_id', $layupId)->orderBy('layer_order')->get();
    }

    public function find($id)
    {
        return CltLayer::findOrFail($id);
    }

    public function findByOrderAndLayup($order, $layupId)
    {
        return CltLayer::where('layer_order', $order)->where('layup_id', $layupId)->first();
    }

    public function create(array $data)
    {
        return CltLayer::create($data);
    }

    public function update($id, array $data)
    {
        $layer = CltLayer::findOrFail($id);
        $layer->update($data);
        return $layer;
    }

    public function delete($id)
    {
        $layer = CltLayer::findOrFail($id);
        return $layer->delete();
    }

    public function deleteByLayup($layupId)
    {
        return CltLayer::where('layup_id', $layupId)->delete();
    }
}
