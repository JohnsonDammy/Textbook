<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommitteeModel;
use App\Models\School;




use PDO;

class CommitteeMember extends Controller
{
//INSERT INTO `committee_member`(`Id`, `School_Emis`, `District_Id`, `Name`, `Designation`, `Contact_No`, `Signature`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')

    public function index(){
        $emis = Auth::user()->username;
        $data = DB::table('committee_member')
        ->where('School_Emis', $emis)
        ->paginate(10);

    return view('furniture.Committee.list', compact('data'));

    }

    public function AddMember(Request $request){

        // INSERT INTO `committee_member`(`Id`, `School_Emis`, `District_Id`, `Name`, `Designation`, `Contact_No`, `Signature`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')

        $emis = Auth::user()->username;
        $ContactNo = $request->input('ContactNo');
        $district_id = School::where('emis', $emis)->value('district_id');

        $Email = $request->input('Email'); // Get the selected option
        $Designation = $request->input('Designation'); // Get the selected option
        $MemberName = $request->input('MemberName'); // Get the selected option

        $ExistMember = CommitteeModel::where('School_Emis', $emis)
        ->where('Contact_No', $ContactNo)->first();


        if($ExistMember == null){
            // echo "Not Exists";

            $CommitteeMember = [
                'School_Emis' => $emis,
                'District_Id' => $district_id,
                'Name' => $MemberName,
                'Designation' => $Designation,
                'Contact_No' => $ContactNo,
                'email' => $Email,

            ];

            DB::table('committee_member')->insert($CommitteeMember);

        //INSERT INTO `logsactivity`(`Id`, `DescriptionActivities`, `Who`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
        $SchoolName = DB::connection('itrfurns')->table('schools')
        ->where('emis', $emis)
        ->value('name');

    $message = "From  :" . $emis . " , " . $SchoolName . " has Added New Member details";
            $Activity_ID = "2";
    $logsactivity = [
        'DescriptionActivities' => $message,
        'Who' => $emis,
        'Activity_ID' => $Activity_ID,
    ];
    DB::table('logsactivity')->insert($logsactivity);

    return redirect()->route('Member.list')->with('success', 'Member Added Successfully');



        }else{
            return redirect()->route('Member.list')->with('errorMessage', 'Cannot Add Member Already Exits');
        }

    }

  

    public function edit($id)
    {
  
        $data  = CommitteeModel::where('Id', $id)->first();

        return view('furniture.Committee.edit', compact('data'));
    }


    public function DeleteMember(Request $request){
        $ID = $request->input('DelVal');


        DB::table('committee_member')
            ->where('Id', $ID)

            ->delete();

        return redirect()->route('Member.list')->with('errorMessage', 'Member delete successfully');

        //DB::table($tables)->delete();
    }

    
    
    public function add()
    {
        return view('furniture.Committee.add');
    }

    public function update(Request $request, $id)
    {

                // INSERT INTO `committee_member`(`Id`, `School_Emis`, `District_Id`, `Name`, `Designation`, `Contact_No`, `Signature`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')

        $ID = $request->input('IDVAl');

        $emis = Auth::user()->username;
        $ContactNo = $request->input('ContactNo');
        $district_id = School::where('emis', $emis)->value('district_id');

        $Email = $request->input('Email'); // Get the selected option
        $Designation = $request->input('Designation'); // Get the selected option
        $MemberName = $request->input('MemberName'); // Get the selected option


        DB::table('committee_member')
            ->where('Id', $ID)

            ->update([
                'Name' => $MemberName,
                'Designation' => $Designation,
                'Contact_No' => $ContactNo,
                'email' => $Email,
            ]);


            
        //INSERT INTO `logsactivity`(`Id`, `DescriptionActivities`, `Who`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
        $SchoolName = DB::connection('itrfurns')->table('schools')
        ->where('emis', $emis)
        ->value('name');

    $message = "From  :" . $emis . " , " . $SchoolName . " has Update Member details";
    $Activity_ID = "2";

    $logsactivity = [
        'DescriptionActivities' => $message,
        'Who' => $emis,
        'Activity_ID' => $Activity_ID,

    ];
    DB::table('logsactivity')->insert($logsactivity);

    return redirect()->route('Member.list')->with('successD', 'Member updated successfully');
    }

    //                // INSERT INTO `committee_member`(`Id`, `School_Emis`, `District_Id`, `Name`, `Designation`, `Contact_No`, `Signature`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')


    public function search(Request $request)
    {
        $emis = Auth::user()->username;
        $query = $request->input('query');
    
        // Use a query to search for records in the SchoolSuppliyerModel
        $data = CommitteeModel::where('School_Emis', $emis)
            ->where(function ($subQuery) use ($query) {
                $subQuery->where('Name', 'like', '%' . $query . '%')
                    ->orWhere('Designation', 'like', '%' . $query . '%')
                    ->orWhere('Contact_No', 'like', '%' . $query . '%')
                    ->orWhere('Signature', 'like', '%' . $query . '%');
            })
            ->paginate(10);
    
        return view('furniture.Committee.list', compact('data'));
    }
}
