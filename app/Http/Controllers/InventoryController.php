<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\CltLayup;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Supplier $supplier, CltLayup $layup)
    {

        $layup->load('cltLayers');
        return view('pages.inventory.inventory', compact('supplier', 'layup'));
    }
}
