<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    function index()
    {
        $suppliers = \App\Models\Supplier::all();
        return view('pages.suppliers.suppliers', ['suppliers' => $suppliers]);
    }

    function show(\App\Models\Supplier $supplier)
    {
        return view('pages.suppliers.show-supplier', ['supplier' => $supplier]);
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        \App\Models\Supplier::create([
            'name' => $request->name,
        ]);

        return redirect()->route('suppliers')->with('success', 'Supplier created successfully.');
    }
}
