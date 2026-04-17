<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CltLayup;
use App\Models\CltLayer;
use App\Services\CltLayerService;

class CltLayerController extends Controller
{
    protected $cltLayerService;

    public function __construct(CltLayerService $cltLayerService)
    {
        $this->cltLayerService = $cltLayerService;
    }

    public function store(Request $request, CltLayup $layup)
    {
        $request->validate([
            'layer_order' => 'required|integer',
            'thickness' => 'required|numeric',
            'width' => 'required|numeric',
            'angle' => 'required|numeric',
        ]);

        $this->cltLayerService->createLayer([
            'layup_id' => $layup->id,
            'layer_order' => $request->layer_order,
            'thickness' => $request->thickness,
            'width' => $request->width,
            'angle' => $request->angle,
        ]);

        return redirect()->back()->with('success', 'Layer created successfully.');
    }

    public function update(Request $request, CltLayup $layup, CltLayer $layer)
    {
        $request->validate([
            'layer_order' => 'required|integer',
            'thickness' => 'required|numeric',
            'width' => 'required|numeric',
            'angle' => 'required|numeric',
        ]);

        $this->cltLayerService->updateLayer($layer->id, [
            'layer_order' => $request->layer_order,
            'thickness' => $request->thickness,
            'width' => $request->width,
            'angle' => $request->angle,
        ]);

        return redirect()->back()->with('success', 'Layer updated successfully.');
    }

    public function destroy(CltLayup $layup, CltLayer $layer)
    {
        $this->cltLayerService->deleteLayer($layer->id);
        return redirect()->back()->with('success', 'Layer deleted successfully.');
    }
}
