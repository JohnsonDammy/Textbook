<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\inbox_school;
use App\Models\SchoolSuppliyerModel;
use App\Models\CommitteeModel;
use Illuminate\Support\Facades\Auth;
 
class inboxSchool extends Controller
{
    public function index()
    {
        $emis =  Auth::user()->username;
        $data = inbox_school::where('school_emis', $emis)->where('activity_name', '!=', 'Completed')->get();
        $countSuppliers = SchoolSuppliyerModel::where('Emis', $emis)->where('IsActive', "1")->count();
        session(['countSuppliers' => $countSuppliers]);
 
        $countComitee = CommitteeModel::where('School_Emis', $emis)->count();
        session(['countComitee' => $countComitee]);

       
 
       // session()->forget('minQuotes');
 
        session()->forget('closingDate');
     
        return view('Section21_C.InboxSchool.inboxSchool',compact('data'));
    }
}
 