<?php

namespace App\Http\Controllers;

use App\Models\RequestFundsModel;
use App\Models\Messages;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\School;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminViewFundsRequest extends Controller
{

    //     public function index(){
    //        // $data = RequestFundsModel::paginate(10);

    //  //$data = RequestFundsModel::with('documentRequest')->find();
    //  $data = RequestFundsModel::with('documentRequest')->paginate(10);


    //         return view('furniture.Funds.ViewFundsRequest.ViewFund', compact('data'));

    // }



    public function index()
    {
        $userOrganizationId = Auth::user()->getOrganization->id;
        $districtId = Auth::user()->District_Id;
    
        $query = RequestFundsModel::select('fundsrequest.*', 'document_request.FilenamePath')
            ->leftJoin('document_request', function ($join) {
                $join->on('fundsrequest.RequestType', '=', 'document_request.RequestType')
                    ->on('fundsrequest.School_Emis', '=', 'document_request.School_Emis');
            });
    
        if ($userOrganizationId != 1) {
            // Filter records based on District_Id
            $query->where('fundsrequest.District_Id', $districtId);
        }
    
        $data = $query->paginate(10);
    
        $School_Emis = RequestFundsModel::where('District_Id', $districtId)->value('School_Emis');
        $SchoolName = School::where('emis', $School_Emis)->value('name');
    
        return view('furniture.Funds.ViewFundsRequest.ViewFund', compact('data', 'SchoolName'));
    }
    



    // public function edit($id)
    // {
    //     $category = StockCategory::find($id);
    //     return view('furniture.maintenance.stock.categories.edit', compact('category'));
    // }


    public function edit($id)
    {
        // Retrieve the record to be edited by its ID
        $record = RequestFundsModel::find($id);
        // $record = RequestFundsModel::with('documentRequest')->find($id);

        if ($record) {
            return view('furniture.Funds.ViewFundsRequest.edit', compact('record'));



            // Handle the case where the record is not found
            // You can redirect or show an error message
        }

        // Load the edit view and pass the record data to it
        // return view('furniture.Funds.edit', compact('record'));
    }


    public function UpdateFundRequest(Request $request)
    {
        $message = $request->input('message');
        $status = $request->input('status');
        $ApprovedAmountTextbook = $request->input('ApprovedAmountTextbook');
        $ApprovedAmountStationery = $request->input('ApprovedAmountStationery');
        $School_Emis = $request->input('School_Emis');
        $RecordID = $request->input('RecordID');
        $RequestType = $request->input('RequestType');

        $district_id = Auth::user()->District_Id;



        // $uploadedFile = $request->file('file');
        // // Get the uploaded file's name
        // $fileName = uniqid() . '_' . $uploadedFile->getClientOriginalName();    
        // $destinationPath='public/uploads';    
        // $uploadedFile->move( $destinationPath, $fileName);





        

        $file = $request->file('file'); // Assuming 'file' is the input name for the uploaded file.

        if ($file) {
            $uniqueId = uniqid(); // Generate a unique ID for the file name.
            $fileuploadname ="Approved Document_". $uniqueId . '.' . $file->getClientOriginalExtension(); // Rename the file with the unique ID and preserve the file extension.
//C:\xampp\htdocs\Project\Textbook\public\ApprovePdf
    $destinationPath='public/ApprovePdf';   
            $file->move($destinationPath, $fileuploadname); // Move the file to a folder with the new name.




            if ($RecordID) {
                DB::table('fundsrequest')
                    ->where('id', $RecordID)

                    ->update([
                        'ApprovedAmountTextbook' => $ApprovedAmountTextbook,
                        'ApprovedAmountStationery' => $ApprovedAmountTextbook,
                        'Document' => $fileuploadname,
                        'Status' => $status,
                    ]);
            }
        }
        //INSERT INTO `indox`(`Id`, `School_Emis`, `District_Id`, `RequestType`, `Message`, `Date`, `year`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')

        $existingRecords1 = Messages::where('School_Emis', $School_Emis)
            ->where('RequestType', $RequestType)
            ->exists();
/* 
        if ($existingRecords1) {
            DB::table('inbox')
                ->where('School_Emis', $School_Emis)
                ->where('RequestType', $RequestType)
                ->update([
                    'Message' => $message,

                ]);
        } else {
            DB::table('inbox')

                ->insert([
                    'Message' => $message,
                    'School_Emis' => $School_Emis,
                    'District_Id' => $district_id,
                    'RequestType' => $RequestType
                ]); */
       // }
        // return redirect()->route('editRoless')->with([
        //     'successa' => $success,
        // ]);

        $success= "Record Successfully Updated";

        return redirect()->route('AdminViewFundRequest.index')->with([
            'successa' => $success,
        ]);
    }




    
    public function search(Request $request)
    {
        // Get search parameters from the request
    $refNumber = $request->input('ref_number');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $schoolName = $request->input('school_name');
    $status = $request->input('status');
    $fundType = $request->input('fundtype');
    $emis = $request->input('emis');
    $district_id = Auth::user()->District_Id;


    // Start building your query
    $query = DB::table('fundsrequest');

    // Apply filters based on the search parameters
if ($refNumber) {
    $query->where('References_Number', $refNumber)
   ->where('district_id', $district_id);
    
}
if ($emis) {
    $query->orWhere('School_Emis', $emis)
    ->where('district_id', $district_id);
    
}
if ($startDate) {
    $startDates = Carbon::createFromFormat('Y/m/d', $startDate)->format('Y-m-d');
    $query->orWhere('Dates', '>=', $startDates)
    ->where('district_id', $district_id);
    
}
if ($endDate) {
    $endDates = Carbon::createFromFormat('Y/m/d', $endDate)->format('Y-m-d');
    $query->orWhere('Dates', '<=', $endDates)
    ->where('district_id', $district_id);
    
}
if ($schoolName) {
    $query->orWhere('School_Name', 'like', '%' . $schoolName . '%')
    ->where('district_id', $district_id);
    

}
if ($status) {
    $query->orWhere('Status', $status)
    ->where('district_id', $district_id);
    

}
if ($fundType) {
    $query->orWhere('RequestType', $fundType)
    ->where('district_id', $district_id);
    
}

// Add the additional where clause for 'district_id'
$query->where('district_id', $district_id);

$data = $query->paginate(10);
    // Check if there are no results
 if ($data->isEmpty()) {
    return redirect()->route('AdminViewFundRequest.index')
        ->with('searcherror', 'Your search did not match any records.')
        ->withInput();
}

return view('furniture.Funds.ViewFundsRequest.ViewFund', compact('data'));
    
        
    }
}
