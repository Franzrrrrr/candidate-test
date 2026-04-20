<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupplierService;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        $suppliers = $this->supplierService->getPaginatedSuppliers(10);
        return view('pages.suppliers.suppliers', ['suppliers' => $suppliers]);
    }

    public function show(\App\Models\Supplier $supplier)
    {
        $layups = $supplier->cltLayups()->withCount('cltLayers')->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.suppliers.show-supplier', ['supplier' => $supplier, 'layups' => $layups]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $this->supplierService->createSupplier([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            // 'ext_id' is nullable or handled if needed
        ]);

        return redirect()->route('suppliers')->with('success', 'Supplier created successfully.');
    }

    public function update(Request $request, \App\Models\Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $this->supplierService->updateSupplier($supplier, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('suppliers')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(\App\Models\Supplier $supplier)
    {
        $this->supplierService->deleteSupplier($supplier);
        return redirect()->route('suppliers')->with('success', 'Supplier deleted successfully.');
    }
}
