<?php
 
namespace App\Http\Controllers;
 
use App\Models\doc_commitee;
use App\Models\doc_disclosure;
use App\Models\School;
use App\Models\SchoolDistrict;
use App\Models\capturedsuppliers;
use App\Models\ef48docs;
use App\Models\RequestFundsModel;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\savedstationeryitems;
use App\Models\inbox_school;
use App\Models\stationeryCatModel;
use Illuminate\Support\Facades\Auth;

 
use Illuminate\Support\Facades\DB;
 
 
use Illuminate\Http\Request;
 
class AdminCaptureSupplierOderController extends Controller
{
    //
 
    public function Capture($requestType, $emis, $fundsId)
    {
 
 
        session(['emis' => $emis]);
 
        $schoolname = School::where('emis', $emis)->value('name');
        $deviationReason = ef48docs::where('school_emis', $emis)->where('requestType', $requestType)->value('deviationReason');
 
        session(['schoolname' => $schoolname]);
 
        session(['fundsId' => $fundsId]);
 
 
        session(['requestType' => $requestType]);
 
 
        //Captured Supplier Table
        $CapturedData = DB::table('suppliyer')
            ->select(
                'suppliyer.email',
                'capturedsuppliers.id AS custom_id', // Use the AS keyword to give a custom name
                'suppliyer.CompanyName',
                'suppliyer.CompanyContact',
                'suppliyer.CompanyAddress',
                'suppliyer.ISActive',
                'suppliyer.CompanyName',
                'capturedsuppliers.amount',
                'capturedsuppliers.savedSupplierID',
                'capturedsuppliers.Recommended',
                'capturedsuppliers.taxClearance',
                'capturedsuppliers.markUp',
                'savedsuppliers.emis',
                'savedsuppliers.requestType'
            )
            ->join('savedsuppliers', 'suppliyer.Id', '=', 'savedsuppliers.supplierID')
            ->join('capturedsuppliers', 'savedsuppliers.id', '=', 'capturedsuppliers.savedSupplierID')
            ->where('savedsuppliers.requestType', '=', $requestType)
            ->where('savedsuppliers.emis', '=', $emis)
            ->get();
 
        session(['CapturedData' => $CapturedData]);

        session(['deviationReason' => $deviationReason]); 
 
 
 

        return view('furniture.AdminSupplierOrder.list')
        ->with('StatusChange', "deviationReason")
        ->with('deviationReason', $deviationReason);

    }
 

    public function CaptureStatUnitPrice($RequestTypes, $Emis, $fundsId){

        session(['Emis' => $Emis]);

        $schoolname = School::where('emis', $Emis)->value('name');
        $deviationReason = ef48docs::where('school_emis', $Emis)->where('requestType', $RequestTypes)->value('deviationReason');

        session(['requestType' => $RequestTypes]);
        session(['fundsId' => $fundsId]);



        $OrdAmountSum = savedstationeryitems::where('school_emis', $Emis)
        ->sum('TotalPrice');

        $AllocatedAmt = inbox_school::where('school_emis', $Emis)->where('requestType', $RequestTypes)->value('allocation');

        

        session(['OrdAmountSum' => $OrdAmountSum]);
 
        session(['schoolname' => $schoolname]);
 
        session(['fundsId' => $fundsId]);

        session(['AllocatedAmt' => $AllocatedAmt]);


        $CapturedData = DB::table('suppliyer')
            ->select(
                'suppliyer.email',
                'capturedsuppliers.id AS custom_id', // Use the AS keyword to give a custom name
                'suppliyer.CompanyName',
                'suppliyer.CompanyContact',
                'suppliyer.CompanyAddress',
                'suppliyer.ISActive',
                'suppliyer.CompanyName',
                'capturedsuppliers.amount',
                'capturedsuppliers.savedSupplierID',
                'capturedsuppliers.Recommended',
                'capturedsuppliers.taxClearance',
                'capturedsuppliers.markUp',
                'savedsuppliers.emis',
                'savedsuppliers.requestType'
            )
            ->join('savedsuppliers', 'suppliyer.Id', '=', 'savedsuppliers.supplierID')
            ->join('capturedsuppliers', 'savedsuppliers.id', '=', 'capturedsuppliers.savedSupplierID')
            ->where('savedsuppliers.requestType', '=', $RequestTypes)
            ->where('savedsuppliers.emis', '=', $Emis)
            ->get();
 
        session(['CapturedData' => $CapturedData]);

        session(['deviationReason' => $deviationReason]); 


        $querySavedItems= savedstationeryitems::where('school_emis', session("Emis"))->paginate(5);
        $dataSavedStationery=$querySavedItems;
        session(['dataSavedStationery' => $dataSavedStationery]);
        


        $itemsWithoutPrice = DB::table('savedstationeryitems')
        ->where('price', null)
        ->where('school_emis', $Emis)
        ->get();

        session(['itemsWithoutPrice' => $itemsWithoutPrice]); 



        return view("Section21_C.RequestQuotation.StationaryCaptureUnit")
        ->with('dataSavedStationery',$dataSavedStationery)
        ->with('RequestTypes', $RequestTypes)
        ->with('Emis', session("Emis"))
        ->with('fundsId' , $fundsId)
        ->with('StatusChange', "deviationReason")
        ->with('deviationReason', $deviationReason)
        ->with('OrdAmountSum', $OrdAmountSum)
        ->with('AllocatedAmt', $AllocatedAmt)
        ->with('itemsWithoutPrice', $itemsWithoutPrice);

    }


    public function searchStationeryNew(Request $request)
    {
        $searchWord = $request->input('searchKeyword');
        session(['searchWord' => $searchWord]);
    
        $emis = session('Emis');
        $RequestTypes = session('requestType');
        $fundsId = session('fundsId');
        $deviationReason = session('deviationReason');
        $AllocatedAmt = session('AllocatedAmt');
        $OrdAmountSum = session('OrdAmountSum');
        $itemsWithoutPrice = session('itemsWithoutPrice');
    
        // Use eloquent to search for items
        $stationeryData = savedstationeryitems::where('item_title', 'like', "%$searchWord%")
            ->where('school_emis', $emis)
            ->paginate(5);
    


        $querySavedItems = savedstationeryitems::where('school_emis', $emis)->paginate(5);
        $dataSavedStationery = $stationeryData;
    
        return view('Section21_C.RequestQuotation.StationaryCaptureUnit')
            ->with('requestType', $RequestTypes)
            ->with('RequestTypes', $RequestTypes)
            ->with('Emis', $emis)
            ->with('fundsId', $fundsId)
            ->with('emis', $emis)
            ->with('searchWord', $searchWord)
            ->with('dataSavedStationery', $dataSavedStationery)
            ->with('stationeryData', $stationeryData)
            ->with('deviationReason', $deviationReason)
            ->with('OrdAmountSum', $OrdAmountSum)
            ->with('AllocatedAmt', $AllocatedAmt)
            ->with('itemsWithoutPrice', $itemsWithoutPrice);
    }

 
 
    public function downloadQuoteAdmin($fileName)
    {
 
        $filename = capturedsuppliers::where('savedSupplierID', session("itemId"))->value('quoteForm');
 
        // Load the PDF from the public path
        $pdfPath = 'public/suppliers/quotes/' . $filename;
 
        // Download the PDF
        return response()->download($pdfPath, $filename);
    }
 
    public function downloadSBD4Admin($fileName)
    {
 
 
        $fileName = capturedsuppliers::where('savedSupplierID', session("itemId"))->value('sbd4Form');
 
        // Load the PDF from the public path
        $pdfPath = 'public/suppliers/sbd4/' . $fileName;
         // Download the PDF
        return response()->download($pdfPath, $fileName);
    }
 

   
    public function downloadDisclosureAdmin($fileName)
    {
 
 
        $fileName = doc_disclosure::where('emis', session("emis"))->where('requestType', session("requestType"))->value('fileName');
 
        //dump($fileName);
        // Load the PDF from the public path
       $pdfPath = 'public/DisclosurePDF_Signed/' . $fileName;
 
        // Download the PDF
        return response()->download($pdfPath, $fileName);
    }


    // public function downloadDisclosureAdminNew($fileName)
    // {
 
 
    //     $fileName = doc_disclosure::where('emis', session("emis"))->where('requestType', session("requestType"))->value('fileName');
 
    //     dump($fileName);
    //     // Load the PDF from the public path
    //   //  $pdfPath = 'public/DisclosurePDF_Signed/' . $fileName;
 
    //     // Download the PDF
    //     //return response()->download($pdfPath, $fileName);
    // }
    

    public function downloadComiteeAdmin()
    {
 
 
        $filename = doc_commitee::where('emis', session("emis"))->where('requestType', session("requestType"))->where('status', "signed")->value('fileName');
 
        // Load the PDF from the public path
        $pdfPath = 'public/ComiteePDF_Signed/' . $filename;
 
 
        // Download the PDF
        return response()->download($pdfPath, $filename);
    }
 
    public function downloadTaxAdmin($fileName)
    {
 
 
        $filename = capturedsuppliers::where('savedSupplierID', session("itemId"))->value('taxClearanceForm');
 
        // Load the PDF from the public path
        $pdfPath = 'public/suppliers/taxClearance/' . $filename;
 
 
        // Download the PDF
        return response()->download($pdfPath, $filename);
    }
 
    public function downloadSignedEF58()
    {
 
 
        $filename = ef48docs::where('school_emis', session('emis'))->where('requestType', session('requestType'))->value('file_Signed');
 
        // Load the PDF from the public path
        $pdfPath = 'public/EF48_Signed/' . $filename;
 
 
        // Download the PDF
        return response()->download($pdfPath, $filename);
    }


   


    public function GenerateChecklistApprove(Request $request)
    {



           
        // Generate the comitee form
        $lowestOffer = $request->input('lowestOffer'); 
        $quotesObtained = $request->input('quotesObtained');
        $taxClearance = $request->input('taxClearance'); 
        $declaredInterest = $request->input('declaredInterest');
        $completedEF58 = $request->input('completedEF58'); 
        $formSubmission = $request->input('formSubmission');  
        $formCompletion = $request->input('formCompletion');  
        $fundsObtained = $request->input('fundsObtained');  
        $recommendation = $request->input('recommendation');  
        
       
        
        $justifyReason = $request->input('JustifyReason');
        $quoteValue = $request->input('quoteValue');
        $catValue = $request->input('catValue');
        $percentagePrice = $request->input('percentagePrice');

 
 
        $schoolname = School::where('emis', session("emis"))->value('name');
 
     
 
        $districtId= School::where('emis', session("emis"))->value('district_id');
        $districtName= SchoolDistrict::where('id', $districtId)->value('district_office');
 
        $pdf = SnappyPDF::loadView('furniture.AdminSupplierOrder.checklist', [
           
            'quotesObtained' => $quotesObtained,
            'taxClearance' => $taxClearance,
            'declaredInterest' => $declaredInterest,
            'lowestOffer' => $lowestOffer,
            'completedEF58' => $completedEF58,
            'formSubmission' => $formSubmission,
            'formCompletion' => $formCompletion,
            'fundsObtained' => $fundsObtained,
            'recommendation' => $recommendation,
            'justifyReason' => $justifyReason,
            'quoteValue' => $quoteValue,
            'catValue' => $catValue,
            'percentagePrice' => $percentagePrice,
            'schoolname' => $schoolname,
            'districtName' => $districtName,
           
 
        ])->setOption('orientation', 'Portrait')->setOption('page-size', 'A4');
 
 
       
        $pdf->setTimeout(600);
 
        $fileName = uniqid() . "_" . session("emis") . "_" . "Checklist.pdf";

        //Update the checklist filename in the inbox table
        DB::table('inbox_school')
        ->where('requestType', session("requestType"))
        ->where('school_emis', session("emis"))
        ->update([
            'checkListName' => $fileName,
            
        ]);
 
        //Move file to folder on sever
        $pdf->save('public/checklist/' . $fileName);
      
        
        //Approve the request ie change the status for the fund
        DB::table('fundsrequest')
        ->where('id', session("fundsId"))
        ->update([
            'Status' => "Approved",
            'comment' => session("comment")

        ]);


       return redirect()->back()->with('StatusChange', 'Request approved.');
    }
 


public function DeclineRequest(Request $request){
    $comment = $request->input('comment');

    session(['comment' => $comment]);



        if ($comment != null) {
            DB::table('fundsrequest')
                ->where('id', session("fundsId"))
                ->update([
                    'Status' => "Declined",
                    'comment' => $comment

                ]);

                DB::table('inbox_school')
                ->where('school_emis', session("emis"))
                ->where('requestType', session("requestType"))
                ->update([
                    'status' => 'Quote Requested',
                    'activity_name' => 'Receive Quote',
                ]);
            return redirect()->back()->with('StatusChange', 'Request declined.');
        } else {
           
            return redirect()->back()->with('StatusChange', 'Request Failed.');
        }

    

    // Handle the case where no valid action is found
}
   
}