<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\CltLayup;
use App\Services\CltLayupService;

class CltLayupController extends Controller
{
    protected $cltLayupService;

    public function __construct(CltLayupService $cltLayupService)
    {
        $this->cltLayupService = $cltLayupService;
    }

    public function store(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->cltLayupService->createLayup([
            'supplier_id' => $supplier->id,
            'name' => $request->name,
        ]);

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Layup created successfully.');
    }

    public function show(Supplier $supplier, CltLayup $layup)
    {
        $layup->load('cltLayers');
        return view('pages.layups.show-layup', ['supplier' => $supplier, 'layup' => $layup]);
    }

    public function update(Request $request, Supplier $supplier, CltLayup $layup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->cltLayupService->updateLayup($layup->id, [
            'name' => $request->name,
        ]);

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Layup updated successfully.');
    }

    public function destroy(Supplier $supplier, CltLayup $layup)
    {
        $this->cltLayupService->deleteLayup($layup->id);
        return redirect()->route('suppliers.show', $supplier)->with('success', 'Layup deleted successfully.');
    }
}
