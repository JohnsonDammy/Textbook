<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\RequestPrecurementModel;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\RequestFundsModel;
use App\Models\UploadModel;

class Funds extends Controller
{
  public function index()
  {

    $emis = Auth::user()->username;

    $AllocatedTextbook=UploadModel::where('EMIS', $emis)->value('TEXTBOOK ALLOCATION');
    $AllocatedStationery=UploadModel::where('EMIS', $emis)->value('STATIONERY ALLOCATION');


    // $TextBoookProcument = RequestPrecurementModel::where('School_Emis', $emis)->value('Textbook'); 
    // $StationaryProcument = RequestPrecurementModel::where('School_Emis', $emis)->value('Stationary'); 
    // $NoDeclaration = RequestPrecurementModel::where('School_Emis', $emis)->value('NoDeclaration'); 
    
    $TextBoookProcument = RequestPrecurementModel::where('School_Emis', $emis)->where('year', date('Y'))->value('Textbook'); 
    $StationaryProcument = RequestPrecurementModel::where('School_Emis', $emis)->where('year', date('Y'))->value('Stationary'); 
    $NoDeclaration = RequestPrecurementModel::where('School_Emis', $emis)->where('year', date('Y'))->value('NoDeclaration');



    if($StationaryProcument=='Yes' && $TextBoookProcument=='Yes')
        {
          $RequestType = "Text and stationery";
        }
       else if ($StationaryProcument=='Yes') 
       {
          $RequestType = "Stationery";
        }
       else if ($TextBoookProcument=='Yes') 
       { 
          $RequestType = "Textbook";
          
       }

       else{
        $RequestType = "No Declaration";

       }
  
   $existingRecords = RequestFundsModel::where('School_Emis', $emis)
   ->where('year', date('Y'))
   ->where('RequestType',$RequestType)
   ->exists();

   $existingCurrentRequest= RequestFundsModel::where('School_Emis', $emis)
   ->where('year', date('Y'))
   ->exists();


   $circular_id=RequestPrecurementModel::where('School_Emis', $emis)->where('year', date('Y'))->value('circular_id');
   

    $currentYear = date('Y');

    $emiss = Auth::user()->username; //500909885858
    $data = RequestFundsModel::where('School_Emis', $emiss)
      ->where('year', $currentYear)
      ->get();

    
    return view('Section21_C.Funds.list', compact('TextBoookProcument', 'StationaryProcument', 'NoDeclaration', 'data', 'existingRecords','currentYear','AllocatedStationery','AllocatedTextbook','existingCurrentRequest','circular_id'));
  
}

  
}
