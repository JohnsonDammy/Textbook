<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inbox_school;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use App\Models\School;

class InboxSchoolDistict extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->username;
        $district_id = User::where('username', $user)->value('District_id');


        $data =   inbox_school::where('district_id', $district_id)
                  ->where("status", "Quote Received")
                  ->paginate(10);
      
                  $SchoolData = School::all();

                  return view('Section21_C.inbox_district.inboxDistrict',compact('data','SchoolData' ));
                }


public function downloadCheckList($emis , $requestType){
    $filename = inbox_school::where('school_emis', $emis)->where('requestType', $requestType)->value('checkListName');
 
    // Load the PDF from the public path
    $pdfPath = 'public/checklist/' . $filename;
    // Download the PDF
    return response()->download($pdfPath, $filename);
}

}