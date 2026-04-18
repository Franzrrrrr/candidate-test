<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\CltLayup;

class InventoryController extends Controller
{
    public function index(Supplier $supplier, CltLayup $layup)
    {
        $layers = $layup->cltLayers()->orderBy('layer_order', 'asc')->paginate(20);
        return view('pages.inventory.inventory', compact('supplier', 'layup', 'layers'));
    }
}
