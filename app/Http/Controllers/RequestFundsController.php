<?php
 
namespace App\Http\Controllers;
use App\Models\RequestFundsModel;
use App\Models\RequestPrecurementModel;
use App\Models\inbox_school;
use Illuminate\Http\Request;
use App\Models\Circuit;
use App\Helpers\SendEmail;
 
use App\Models\SchoolDistrict;
use Illuminate\Support\Facades\DB;
 
use App\Models\School; // Import the School model if it's not already imported
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
 
class RequestFundsController extends Controller
{
    // Insert a fund request into the fundsreuest table, pass success message and the data object to be used in unds.index
    public function InsertTextbookFunds(Request $request) {
        $emis = $request->input('SchoolEmis');
 
        $district_id = School::where('emis', $emis)->value('district_id');
 
        $schoolPrincipal = School::where('emis', $emis)->value('school_principal');
        $currentYear = date('Y');
 
        $TextBoookProcument = RequestPrecurementModel::where('School_Emis', $emis)->where('year', date('Y'))->value('Textbook');
        $StationaryProcument = RequestPrecurementModel::where('School_Emis', $emis)->where('year', date('Y'))->value('Stationary');
 
        $fieldFundName='';
       
 
        inbox_school::where('school_emis', $emis)->delete();

        // Insert quote cases records based on the request type
    if ($StationaryProcument === "Yes" && $TextBoookProcument === "Yes") {
       // dump("Textbook & Stationary Proc:".$StationaryProcument. "   " . $TextBoookProcument);

              
            $RequestType = "Textbook and Stationery";
 

                DB::table('inbox_school')->insert([
                    'requestType' => "Stationery",
                    'allocation' => $request->input('secondAmount'),
                    'status' => "Allocated Funds",
                    'activity_name' => "Create Quote",
                    'school_emis' => $emis,
                    'district_id' => $district_id
    
                ]);
            
 
            DB::table('inbox_school')->insert([
                'requestType' => "Textbook",
                'allocation' => $request->input('firstAmount'),
                'status' => "Allocated Funds",
                'activity_name' => "Create Quote",
                'school_emis' => $emis,
                'district_id' => $district_id
            ]);
 
        
    } elseif ($StationaryProcument === "Yes") {
    //    dump("Stationary". $StationaryProcument);

      
            $RequestType = "Stationery";
            DB::table('inbox_school')->insert([
                'requestType' => "Stationery",
                'allocation' => $request->input('secondAmount'),
                'status' => "Allocated Funds",
                'activity_name' => "Create Quote",
                'school_emis' => $emis,
                'district_id' => $district_id

            ]);
        
    } elseif ($TextBoookProcument === "Yes") {
     //   dump("Textbook". $TextBoookProcument);

            $RequestType = "Textbook";
            DB::table('inbox_school')->insert([
                'requestType' => "Textbook",
                'allocation' => $request->input('firstAmount'),
                'status' => "Allocated Funds",
                'activity_name' => "Create Quote",
                'school_emis' => $emis,
                'district_id' => $district_id

            ]);
        }
    
       //INSERT INTO fundsrequest(id, References_Number, School_Emis, School_Name, amount_stationery, RequestType, Status, Action_By, Message, year, date, ApprovedAmount, Document, amount_textbook, District_Id) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]')
       
        $existingRecords = RequestFundsModel::where('School_Emis', $emis)
            ->where('year', date('Y'))
            ->exists();
            $uniqueRandomNumber = mt_rand(100000, 999999);
            $datenumbers = date("Ymd");

            $ReferencesID = "Ref" . "_" . $emis . "_" ;
   
        if ($existingRecords==false) {
           
           // $RequestType = "Textbook";
            $Status = "Funds Requested";
           
   
            $insertedId = DB::table('fundsrequest')->insertGetId([
                'References_Number' => "",
                'School_Emis' => $request->input('SchoolEmis'),
                'School_Name' => $request->input('SchoolName'),
                'amount_stationery' => $request->input('secondAmount'),
                'amount_textbook' => $request->input('firstAmount'),
                'RequestType' => $RequestType,
                'Status' => $Status,
                'Action_By' => $schoolPrincipal,
                'year' => $currentYear,
            ]);
 
            $refNo= $ReferencesID.$datenumbers."_".$insertedId;
         //   dump($refNo);
            DB::table('fundsrequest')
            ->where('school_emis', $emis)
            ->where('year',date('Y') )
            ->update([
                'References_Number'=>  $refNo,
            ]);
 
            DB::table('inbox_school')
            ->where('school_emis', $emis)
            ->update([
                'funds_request_id'=>$insertedId ,
                'referenceNo'=>   $refNo,
            ]);
 
 
            // DB::table('inbox_school')
            // ->update([
            //     'funds_request_id'=>$insertedId ,
            //     'referenceNo'=>  $ReferencesID,
 
            // ]);
 
            $SchooName = $request->input('SchoolName');
            $SchooEmis = $request->input('SchoolEmis');
 
 
 
            $firstWords = "Allocation Funds";
 
            $Request = "Fund Request";
 
            $messages  = "Section 21 C -  " . $ReferencesID . "
 
Good day,
 
Please note that " . $SchooName . " – EMIS Number  :" . $SchooEmis . " has requested to use their allocated funds.
 
Regards
System Support
";
 
            $inboxData = [
                // 'RequestFundsId' => $ProcurementSelectId,
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
 
 
 
            $message = "From  :" . $emis . " , " . $SchooName . "has Request For Funds Allocation";
 
            $Activity_ID = "4";
            $logsactivity = [
                'Activity_ID' => $Activity_ID,
 
                'DescriptionActivities' => $message,
                'Who' => $emis,
            ];
            DB::table('logsactivity')->insert($logsactivity);
 
 
            $Year = date('Y');
 
            $success = "Funds Allocated For " . $currentYear;
 
            SendEmail::sendnotificationew($SchooName, $Year, $messages, $emis, $ReferencesID);
 
 
 
            $success = "Funds Allocated For".$currentYear ;
 
           
           
       
            return redirect()->route('inboxSchool')->with([
                 'success' => $success,
             ]);
        }
        else
        {
 
            $fundsRequestId=RequestFundsModel::where('School_Emis', $emis)->value('id');
            $refNo= RequestFundsModel::where('School_Emis', $emis)->where('year', date('Y'))->value('References_Number');
            $uniqueRandomNumber = mt_rand(100000, 999999);
          
            DB::table('fundsrequest')
            ->where('School_Emis', $emis)  
            ->where('year', $currentYear)
            ->update([
                'amount_stationery' => $request->input('secondAmount'),
                'amount_textbook'=> $request->input('firstAmount'),
                'RequestType' => $RequestType,
                'Action_By' => $schoolPrincipal,
            ]);

          
 
            DB::table('inbox_school')
            ->where('school_emis', $emis)  

            ->update([
                'funds_request_id'=>$fundsRequestId,
                'referenceNo'=>  $refNo,
            ]);
 
            $success = "Funds Allocated For ".$currentYear ;
 
           
             return redirect()->route('inboxSchool')->with([
                 'success' => $success,
             ]);
        }
     
    }
 
 
    // Function finds the document id to download from the documents table and will download it from the upload folder on the server.
    public function download($documentId)
    {
     
        $document = DB::table('documents')->where('id', $documentId)->first();
   
        // Check if the document exists
        if ($document) {
            $filePath = 'public/uploads/'.$document->name;
   
            // Check if the file exists in storage
          if (Storage::exists($filePath)) {
                // Generate a download response
                return response()->download(storage_path('app/'.$filePath), $document->name,  ['Content-Disposition' => 'attachment']);
               
           }
   
           
        }
 
        return redirect()->route('Funds.index');
    }
 
 
 
 
 
 
 
 
 
   
}