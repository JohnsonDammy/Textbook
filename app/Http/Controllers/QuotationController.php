<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {

      //  $data =  $this->collectionRequestRepository->getAllManageRequest();
        return view('furniture.Quotation.quote');
    }
}
