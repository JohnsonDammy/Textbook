<?php
 
namespace App\Http\Controllers;
 
use App\Models\doc_disclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CommitteeModel;
use App\Models\doc_commitee;
use App\Models\inbox_school;
use App\Models\doc_quote;
use App\Models\savedSuppliers;
use App\Helpers\SendEmail;
use App\Models\SchoolDistrict;
use App\Models\Circuit;
use App\Models\School;
use Barryvdh\Snappy\Facades\SnappyPdf;
 
class chooseSupplier extends Controller
{
    public function index($requestType , $MinQuotes, Request $request)
    {
 
 
 
        $emis = Auth::user()->username;
        session(['emis' => $emis]);
 
        session(['requestType' => $requestType]);
 
 
        $closingDate = $request->input('closingDate');
 
 
 
 
 
        $supplierData = DB::table('suppliyer')
        ->join('school_suppliyer', 'suppliyer.Id', '=', 'school_suppliyer.Suppliyer_id')
        ->where('school_suppliyer.Emis', '=', session('emis'))
        ->where('school_suppliyer.IsActive', '=', "1")
        ->select( 'suppliyer.Id','suppliyer.email', 'suppliyer.CompanyName', 'suppliyer.CompanyAddress', 'suppliyer.CompanyContact') // Add other columns as needed
        ->get();

            session(['supplierData' => $supplierData]);
 
        $savedSuppliers= savedSuppliers::where('emis', $emis)->where('requestType', session('requestType'))->get();
 
        session(['savedSuppliers' => $savedSuppliers]);
 
       
       
           
        // Generate the comitee form
        $comiteeData = CommitteeModel::where('School_Emis', $emis)->get();
        $schoolname = School::where('emis', $emis)->value('name');
 
        session(['schoolname' => $schoolname]);
 
        $districtId= School::where('emis', $emis)->value('district_id');
        $districtName= SchoolDistrict::where('id', $districtId)->value('district_office');
 
        $circuitId= School::where('emis', $emis)->value('circuit_id');
        $circuitName= Circuit::where('id', $circuitId)->value('circuit_name');
 
 
 
        $pdf = SnappyPDF::loadView('Section21_C.Suppliers.commitee_PDF_HTML', [
            'comiteeData' => $comiteeData,
            'emis' => $emis,
            'schoolname' => $schoolname,
            'districtName' => $districtName,
            'circuitName' => $circuitName,
 
        ])->setOption('orientation', 'Portrait')->setOption('page-size', 'A4');
 
 
       
        $pdf->setTimeout(600);
 
        $fileName = uniqid() . "_" . $emis . "_" . "Comitee.pdf";
 
        $pdf->save('public/ComiteePDF_Unsigned/' . $fileName);
 
       
 
     
        $comiteeDocExist= doc_commitee::where('emis',  $emis )->where('requestType', session('requestType'))->where('status', "unsigned")->exists();
 
        if($comiteeDocExist)
 
        {
            DB::table('doc_commitee')
            ->where('emis',  $emis )->where('requestType', session('requestType'))->where('status', "unsigned")
            ->update([
                'fileName' => $fileName,
             
            ]);
        }
        else
        {
         DB::table('doc_commitee')
            ->insert([
                'emis' => $emis,
                'fileName' => $fileName,
                'requestType' =>  $requestType,
                'status' => 'unsigned'
 
            ]);
        }
 
       
        session(['supplierData' => $supplierData]);
        return view('Section21_C.Suppliers.chooseSuppliers')
            ->with('requestType', $requestType)
            ->with('MinQuotes' ,  $MinQuotes);
    }
 
 
    public function downloadComitee()
    {
        $emis = auth()->user()->username;
        $requestType = session('requestType', 'default_value_if_not_set');
 
        $filename = doc_commitee::where('emis', $emis)->where('requestType',   $requestType )->value('fileName');
 
        // Load the PDF from the public path
        $pdfPath = 'public/ComiteePDF_Unsigned/' . $filename;
 
       
         // Download the PDF
        return response()->download($pdfPath, $filename);
    }
 
    public function downloadDisclosure()
    {
   
 
        $filename = "disclosure_standard.pdf";
 
        // Load the PDF from the public path
        $pdfPath = 'public/DisclosurePDF_Signed/' . $filename;
 
       
         // Download the PDF
        return response()->download($pdfPath, $filename);
    }
 
    public function requestQuote(Request $request)
    {
 
 
        $checkAllStatus = $request->input('checkAllStatus');
 
 
        $closingDate = $request->input('closingDate');
 
     
 
        session(['closingDate' => $closingDate]);
 
        if ($checkAllStatus == 'true') {
            $selectedSuppliers= false ;
        } else {
            $selectedSuppliers= true;
         
        }
 
 
     
        //Store the forms
        $comiteeDocExist= doc_commitee::where('emis',  session('emis') )->where('requestType', session('requestType'))->where('status', "signed")->exists();
 
        if($comiteeDocExist)
 
        {
            /* DB::table('doc_commitee')
            ->where('emis',  session('emis') )->where('requestType', session('requestType'))->where('status', "signed")
            ->update([
                'fileName' => $fileNameComitee,
               
            ]); */
        }
        else
        {
 
            $request->validate([
                'fileComitee' => 'required|file|mimes:pdf,doc,docx',
               
            ]);
   
           
            $uploadedFileComitee = $request->file('fileComitee');
   
           
   
            $fileNameComitee = uniqid() . '_' . $uploadedFileComitee->getClientOriginalName();
   
            $fileCommiteeName = $uploadedFileComitee->getClientOriginalName();
            session(['fileCommiteeName' => $fileCommiteeName]);
   
            $destinationPath = "public/ComiteePDF_Signed";
   
            $uploadedFileComitee->move($destinationPath, $fileNameComitee);
 
         DB::table('doc_commitee')
            ->insert([
                'emis' => session('emis'),
                'fileName' => $fileNameComitee,
                'requestType' =>  session('requestType'),
                'status' => 'signed'
 
 
            ]);
        }
 
 
        $disclosureExists= doc_disclosure::where('emis',  session('emis') )->where('requestType', session('requestType'))->exists();
 
        if($disclosureExists)
 
        {
           /*  DB::table('doc_disclosure')
            ->where('emis',  session('emis') )->where('requestType', session('requestType'))
            ->update([
               
                'fileName' => $fileNameDisclosure,
               
            ]); */
        }
        else
        {
 
        //2> Disclosure form
        $request->validate([
            'fileDisclosure' => 'required|file|mimes:pdf,doc,docx',
           
        ]);
 
     
        $uploadedFileDisclosure = $request->file('fileDisclosure');
 
        $fileNameDisclosure = uniqid() . '_' . $uploadedFileDisclosure->getClientOriginalName();
 
 
        $fileDisclosureName = $uploadedFileDisclosure->getClientOriginalName();
        session(['fileDisclosureName' => $fileDisclosureName]);
 
        $destinationPath = "public/DisclosurePDF_Signed";
 
        $uploadedFileDisclosure->move($destinationPath, $fileNameDisclosure);
 
         DB::table('doc_disclosure')
            ->insert([
                'emis' => session('emis'),
                'fileName' => $fileNameDisclosure,
                'requestType' =>  session('requestType')
 
            ]);
        }
 
 
 
 
        // Get all the files paths
        $quoteFile=doc_quote::where('Emis',  session('emis') )->where('requestType', session('requestType'))->value('FileName');

        if(session("requestType")=="Textbook")
        {
            $attachQuote = "public/GenPdf/" . $quoteFile;
        }
        else
        {
            $attachQuote = "public/GenPdfStat/" . $quoteFile;
        }

 
      /*   $commiteeFile=doc_commitee::where('emis',  session('emis') )->where('requestType', session('requestType'))->where('status', "signed")->value('fileName');
        $attachComitee= "public/ComiteePDF_Signed/" .$commiteeFile;
 
        $disclosureFile= doc_disclosure::where('emis',  session('emis') )->where('requestType', session('requestType'))->value('fileName');
        $attachDisclosure="public/DisclosurePDF_Signed/"  .$disclosureFile;
      */

        $attachSBD4= "public/pdf/sbd4_standard.pdf";
 
        $refNo= inbox_school::where('school_emis', session('emis'))->where('requestType', session('requestType'))->value('referenceNo');
 
 
        $closingDate = $request->input('closingDate');
 
     
        //Delete unchecked suppliers
        $uncheckedItems = explode(',', $request->input('UncheckedItems'));
        foreach ($uncheckedItems as $itemId) {
            savedSuppliers::where('supplierID', $itemId)->delete();
        }
 
        if($selectedSuppliers == true)
        {
            $selectedItemIds = $request->input('selectedItems', []);
 
            $numberOfCheckedItems = count($selectedItemIds);
 
            if($numberOfCheckedItems >= 0 && $numberOfCheckedItems <= 2)
            {
                $belowMinSelection = true;
             
   
            }
            else
            {
                $checkedSuppliers  = DB::table('suppliyer')
                ->whereIn('Id', $selectedItemIds)
                ->get();
                $belowMinSelection = false;
            }
   
 
         
           
        }
        else
        {
            $checkedSuppliers = session('supplierData');
            $belowMinSelection = false;
 
        }
       
 
        //Email each supplier
 
       
        if($belowMinSelection == false)
        {
            foreach($checkedSuppliers as $supplier)
       
            {
       
            $email = $supplier->email;
 
 
            // Insert selected suppliers in database
            $existingSavedSuppliers = savedSuppliers::where('emis',  session('emis') )->where('requestType', session('requestType'))->where('supplierID', $supplier->Id )->exists();
            if( $existingSavedSuppliers)
            {
                DB::table('savedsuppliers')
                ->where('emis',  session('emis') )->where('requestType', session('requestType'))->where('supplierID', $supplier->Id )
                ->update([
                   
                    'emis' => session('emis'),
                    'supplierID' => $supplier->Id,
                    'requestType' => session('requestType')
                   
                ]);
            }
            else
            {
                DB::table('savedsuppliers')
                ->insert([
                    'emis' => session('emis'),
                    'supplierID' => $supplier->Id,
                    'requestType' => session('requestType')
               
 
                ]);
           }
         
 
            SendEmail::sendSupplierEmail($refNo, $closingDate, $attachQuote,$attachSBD4 , $email, session('schoolname'));
            $sucessEmail = true;
 
            }
 
         
            //Change in inbox box to move foward to next step
 
            DB::table('inbox_school')
            ->where('requestType', session('requestType'))
            ->where('school_emis', session('emis'))
            ->update([
                'status' => 'Quote Requested',
                'activity_name' => 'Receive Quote',
            ]);
 
         
 
       }
       else
       {
        $sucessEmail = false;
       }
 
       
 
 
        return redirect()->back()->with([
            'belowMinSelection' => $belowMinSelection,
            'successEmail' => $sucessEmail,
         
 
        ]);
       
}
}