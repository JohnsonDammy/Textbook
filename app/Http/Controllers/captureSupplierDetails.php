<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class captureSupplierDetails extends Controller
{
    public function index($itemId)
    {


        session(['itemId' => $itemId]);
        return view('Section21_C.Receive_Quote.captureSuppliers')
        ->with('requestType', session("requestType"))
        ->with('itemId', session('itemId')); 
    }
}
