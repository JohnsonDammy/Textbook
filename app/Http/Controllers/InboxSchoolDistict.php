<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inbox_school;
use App\Models\School;
use App\Models\user;
use Illuminate\Support\Facades\Auth;

class InboxSchoolDistict extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->username;
        $district_id = User::where('username', $user)->value('District_id');

        $SchoolData = School::all();



        $data =   inbox_school::where('district_id', $district_id)
                  ->where("status", "Quote Received")
                  ->get();
      



        return view('Section21_C.inbox_district.inboxDistrict',compact('data','SchoolData' ));
    }
}


