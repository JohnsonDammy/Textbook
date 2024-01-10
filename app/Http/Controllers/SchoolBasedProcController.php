<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Circuit;
use App\Models\RequestFundsModel;
use App\Models\SchoolDistrict;
use Illuminate\Support\Facades\DB;

use App\Models\School; // Import the School model if it's not already imported
use Illuminate\Http\Request;

class SchoolBasedProcController extends Controller
{
    public function ShowPdf(){
        $principal = "Johnson";

    }


    //
    public function showSchoolBasedProc(Request $request) {



        $emis =  Auth::user()->username;

        
        $principal = "Johnsonssss";
 
        $schoolName = School::where('emis', $emis)->value('name');
        $schoolEmis = $emis; 
        $textBookAmount = RequestFundsModel::where('School_Emis', $emis)->value('FundsAmount');
 
 
        $emis =  Auth::user()->username;
        $SchoolDisctrictID = School::where('emis', $emis)->value('district_id');
        $SchoolCirCuitID = School::where('emis', $emis)->value('circuit_id');
 
 
         // Retrieve the district_office value based on $SchoolDisctrictID
    $districtOffice = SchoolDistrict::where('id', $SchoolDisctrictID)->value('district_office');
 
        $curcuitname = Circuit::where('id', $SchoolCirCuitID)->value('circuit_name');
 
 
     
     return view('furniture.Funds.SchoolBasedProc', compact('schoolName', 'schoolEmis', 'textBookAmount', 'principal', 'districtOffice', 'curcuitname' ));
 

    }

    public function generatePdf() {
        
        $emis =  Auth::user()->username;

        
        $principal = "Johnsonssss";
 
        $schoolName = School::where('emis', $emis)->value('name');
        $schoolEmis = $emis; 
        $textBookAmount = RequestFundsModel::where('School_Emis', $emis)->value('FundsAmount');
 
 
        $emis =  Auth::user()->username;
        $SchoolDisctrictID = School::where('emis', $emis)->value('district_id');
        $SchoolCirCuitID = School::where('emis', $emis)->value('circuit_id');
 
 
         // Retrieve the district_office value based on $SchoolDisctrictID
    $districtOffice = SchoolDistrict::where('id', $SchoolDisctrictID)->value('district_office');
 
        $curcuitname = Circuit::where('id', $SchoolCirCuitID)->value('circuit_name');


        $pdf = PDF::loadView('furniture.Funds.SchoolBasedProc', compact('principal', 'schoolName', 'schoolEmis', 'textBookAmount', 'districtOffice', 'curcuitname'));
        $pdf->save('public/GenPdf/school_based_proc.pdf');


        return $pdf->stream('school_based_proc.pdf');


        
    }
    
}
