<?php

namespace App\Http\Controllers;
use App\Models\Inbox;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class Notification extends Controller
{
    //

    public function index(){

        $districtId = Auth::user()->District_Id;

        // Use the paginate() method to get paginated results
        $data = Inbox::where('District_Id', $districtId)
        ->where('DelVal', '1')
        ->orderBy('Date', 'desc') // Order by Date in descending order
        ->paginate(10);
        return view('furniture.notification.inbox', compact('data'));

    }


    public function searches(Request $request)
     {

    // INSERT INTO `inbox`(`Id`, `RequestFundsId`, `School_Emis`, `References_Number`, `District_Id`, `SchoolName`, `RequestType`, `Request`, `Message`, `Date`, `year`, `seen`, `DelVal`, `DateTime`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]')
    $districtId = Auth::user()->District_Id;

    $startDate = $request->input('start_date');
    $schoolName = $request->input('school_name');
    $fundType = $request->input('fundtype');
    $emis = $request->input('emis');
    $district_id = Auth::user()->District_Id;

    $query = Inbox::where('District_Id', $districtId)
        ->where('DelVal', '1');

    // Check if the 'emis' input field is filled

    if ($request->filled('emis')) {
        if ($request->has('emis')) {
        $query->where('School_Emis', $request->input('emis'));
    }
}


    // Check if the 'school_name' input field is filled
    if ($request->filled('school_name')) {

    if ($request->has('school_name')) {
        $query->where('SchoolName', $request->input('school_name'));
    }
}

    // // Check if the 'start_date' input field is filled
    // if ($request->has('start_date')) {
    //     $query->whereDate('Date', '=', $request->input('start_date'));
    // }

    // // Check if the 'fundtype' input field is filled
    // if ($request->has('fundtype') && $request->input('fundtype') !== 'Request Type') {
    //     $query->where('RequestType', $request->input('fundtype'));
    // }

    $data = $query->orderBy('Date', 'desc')->paginate(10);

    // if ($data->isEmpty()) {
    //     return redirect()->route('notification')
    //         ->with('searcherror', 'Your search did not match any recordss.')
    //         ->withInput();
    // }

    return view('furniture.notification.inbox', compact('data'));
    }

   
    //INSERT INTO `inbox`(`Id`, `RequestFundsId`, `School_Emis`, `References_Number`, `District_Id`, `SchoolName`, `RequestType`, `Request`, `Message`, `Date`, `year`, `seen`, `DelVal`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]')
    public function search(Request $request)
    {
     
        $startDate = $request->input('start_date');
        $schoolName = $request->input('school_name');
        $fundType = $request->input('fundtype');
        $emis = $request->input('emis');
        $district_id = Auth::user()->District_Id;


        // Start building your query
        $query = DB::table('inbox');


        if ($emis) {
            $query->orWhere('School_Emis', $emis)
                ->where('district_id', $district_id);
        }
        elseif ($startDate) {
            $startDates = Carbon::createFromFormat('Y/m/d', $startDate)->format('Y-m-d');
            $query->orWhere('Dates', '>=', $startDates)
                ->where('district_id', $district_id);
        }
   
        elseif ($schoolName) {
            $query->orWhere('School_Name', 'like', '%' . $schoolName . '%')
                ->where('district_id', $district_id);
        }

        elseif ($fundType) {
            $query->orWhere('RequestType', $fundType)
                ->where('district_id', $district_id);
        }

        // Add the additional where clause for 'district_id'
        $query->where('district_id', $district_id);

        $data = $query->paginate(10);
        // Check if there are no results
        if ($data->isEmpty()) {
            return redirect()->route('notification')
                ->with('searcherror', 'Your search did not match any recordss.')
                ->withInput();
        }

        return view('furniture.notification.inbox', compact('data'));
    }
}
