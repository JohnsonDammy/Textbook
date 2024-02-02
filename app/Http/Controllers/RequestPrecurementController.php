<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\RequestPrecurementModel;
use App\Models\UploadModel;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendEmail;
use App\Models\School; // Import the School model if it's not already imported



class RequestPrecurementController extends Controller
{
    public function index()
    {
        $emis = Auth::user()->username;
        $existAllocation = UploadModel::where('EMIS', $emis)->exists();


        if ($existAllocation) {

            $AllowProcurement = true;

        } else {
            $AllowProcurement = false;
        }
        return view('Section21_C.RequestPrecurement.Request', compact('AllowProcurement'));
    }

    public function processSelection(Request $request)
    {

        // Validate the file upload
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx',
            // Adjust allowed file types
        ]);

        //Upload file onto uploads folder
        $uploadedFile = $request->file('file');

        $fileName = uniqid() . '_' . $uploadedFile->getClientOriginalName();

        $destinationPath = storage_path('app/public/uploads');

        $uploadedFile->move($destinationPath, $fileName);

        $emis = $request->input('SchoolEmis');
        $schoolPrincipal = School::where('emis', $emis)->value('school_principal');


        $currentYear = date('Y');
        $selectedOption = $request->input('options'); // Get the selected option


        if ($selectedOption != null) {



            $existingRecord = RequestPrecurementModel::where('School_Emis', $emis)
                ->where('year', $currentYear)
                ->first();

            $circular_id = RequestPrecurementModel::where('School_Emis', $emis)->where('year', $currentYear) > value('circular_id');


            try {
                if ($existingRecord) {

                    // Update documents table for the current procurement and unlink the previous file on the server 
                    $fileNameDelete = Document::where('id', $circular_id)->value('name');
                    $filePathDelete = '/storage/app/public/uploads' . $fileNameDelete;
                    if (file_exists($filePathDelete)) {
                        unlink($filePathDelete);
                    }

                    DB::table('documents')
                        ->update([
                            'name' => $fileName,
                        ]);


                    // Update the procurement table
                    DB::table('procurementselection')
                        ->where('School_Emis', $emis)
                        ->where('year', $currentYear)
                        ->update([
                            'Textbook' => ($selectedOption == 'Textbook procurement' || $selectedOption == 'TextbookAndStationary') ? 'Yes' : 'No',
                            'Stationary' => ($selectedOption == 'Stationary procurement' || $selectedOption == 'TextbookAndStationary') ? 'Yes' : 'No',
                            'NoDeclaration' => ($selectedOption == 'NoDeclaration') ? 'Yes' : 'No',

                        ]);
                    // $selectedV = $request->input('options');

                    $selectedV = $request->input('options');
                    $selectedVArray = explode(' ', $selectedV);
                    $firstWord = $selectedVArray[0];

                    $SchooName = $request->input('SchoolName');
                    $Year = date('Y');
                    $today = date('Y-m-d');
                    $messages = "From: " . $SchooName . "\nHave Successfully Select                   : " . $selectedV . " For the Year " . $Year;
                    $Request = "Procurement Selection";

                    DB::table('inbox')->update([
                        'RequestType' => $firstWord,
                        'Message' => $messages,
                        'Date'=> $today,
                        'year'=> $today,
                        'DelVal' => "1"

                    ]);

                    SendEmail::sendnotification($SchooName, $Year, $selectedV, $emis);

                    $emis = Auth::user()->username;
                    $circular_id = RequestPrecurementModel::where('School_Emis', $emis)->value('Textbook');
                    $TextBoookProcument = RequestPrecurementModel::where('School_Emis', $emis)->value('Textbook');
                    $StationaryProcument = RequestPrecurementModel::where('School_Emis', $emis)->value('Stationary');
                    $NoDeclaration = RequestPrecurementModel::where('School_Emis', $emis)->value('NoDeclaration');

                    return redirect()->route('Funds.index');


                } else {

                    // Insert into the documents table indicating new procurement
                    $circular_id = DB::table('documents')->insertGetId([
                        'name' => $fileName,
                    ]);

                    // Insert data into the 'procurementselection' table
                    // DB::table('procurementselection')->insert(
                    // $selectedV = $request->input('options');

                    $selectedV = $request->input('options');
                    $selectedVArray = explode(' ', $selectedV);
                    $firstWords = $selectedVArray[0];

                    $referenceData = [
                        'Textbook' => ($selectedOption == 'Textbook procurement' || $selectedOption == 'TextbookAndStationary') ? 'Yes' : 'No',
                        'Stationary' => ($selectedOption == 'Stationary procurement' || $selectedOption == 'TextbookAndStationary') ? 'Yes' : 'No',
                        'NoDeclaration' => ($selectedOption == 'No declaration') ? 'Yes' : 'No',

                        'School_Emis' => $request->input('SchoolEmis'),
                        'SchoolName' => $request->input('SchoolName'),


                        'ActionBy' => $schoolPrincipal,
                        'Year' => $currentYear,
                        'circular_id' => $circular_id,

                    ];

                    $ProcurementSelectId = DB::table('procurementselection')->insertGetId($referenceData);
                    $district_id = School::where('emis', $emis)->value('district_id');

                    // Prepare the message for 'inbox' table
                    $SchooName = $request->input('SchoolName');
                    $Year = date('Y');
                    $messages = "From: " . $SchooName . "\nHave Successfully Select                  :" . $selectedV . " For the Year " . $Year;
                    $Request = "Procurement Selection";

                    // Insert data into 'inbox' table using the obtained $fundsRequestId
                    $inboxData = [
                        'RequestFundsId' => $ProcurementSelectId,
                        'School_Emis' => $request->input('SchoolEmis'),
                        'SchoolName' => $request->input('SchoolName'),
                        'District_Id' => $district_id,
                        'RequestType' => $firstWords,
                        'Message' => $messages,
                        'Request' => $Request,
                        'seen' => "0",
                        'DelVal' => "1",
                        //   'Date' => now(), // You can set the date to the current timestamp
                        //'year' => $Year,
                    ];

                    DB::table('inbox')->insert($inboxData);
                    $success = "Successfully created your request for " . $currentYear;
                    $emis = Auth::user()->username;


                    SendEmail::sendnotification($SchooName, $Year, $selectedV, $emis);


                    $emis = Auth::user()->username;
                    $TextBoookProcument = RequestPrecurementModel::where('School_Emis', $emis)->value('Textbook');
                    $StationaryProcument = RequestPrecurementModel::where('School_Emis', $emis)->value('Stationary');
                    $NoDeclaration = RequestPrecurementModel::where('School_Emis', $emis)->value('NoDeclaration');

                    return redirect()->route('Funds.index');

                }

                
                // $emis =  Auth::user()->username;
                  
                //  return redirect()->route('Funds.index');

            } catch (Exception $e) {
                return redirect()->route('Funds.index')->with('errorMessage', 'Failed to process procurement selection');
            }

        }

    }

}
