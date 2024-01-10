<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FundsController extends Controller
{
    public function index()
    {
      //  $data =  $this->collectionRequestRepository->getAllManageRequest();
        return view('furniture.Funds.list');
    }
}
