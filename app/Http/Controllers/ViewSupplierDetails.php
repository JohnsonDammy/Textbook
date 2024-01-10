<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\capturedsuppliers;

class ViewSupplierDetails extends Controller
{
    public function index($itemId)
    {


        session(['itemId' => $itemId]);
        $supplierRec = capturedsuppliers::where('savedSupplierID', $itemId)->first();
        return view('furniture.AdminSupplierOrder.viewDetails')
        ->with('requestType', session("requestType"))
        ->with('itemId', session('itemId'))
        ->with('supplierRec',  $supplierRec );
    }
}
