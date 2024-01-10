<?php
 
namespace App\Http\Controllers;
 
use App\Models\School;
use App\Models\capturedsuppliers;
use App\Models\ef48docs;
use App\Models\RequestFundsModel;
 
use Illuminate\Support\Facades\DB;
 
 
use Illuminate\Http\Request;
 
class AdminCaptureSupplierOderController extends Controller
{
    //
 
    public function Capture($requestType, $emis, $fundsId)
    {
 
 
        session(['emis' => $emis]);
 
        $schoolname = School::where('emis', $emis)->value('name');
 
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
 
 
 
        return view('furniture.AdminSupplierOrder.list')
        ->with('StatusChange', "");
        // return view('furniture.AdminSupplierOrder.list');
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
 
 
        $filename = capturedsuppliers::where('savedSupplierID', session("itemId"))->value('sbd4Form');
 
        // Load the PDF from the public path
        $pdfPath = 'public/suppliers/sbd4/' . $filename;
 
 
        // Download the PDF
        return response()->download($pdfPath, $filename);
    }
 
    public function downloadDisclosureAdmin($fileName)
    {
 
 
        $filename = capturedsuppliers::where('savedSupplierID', session("itemId"))->value('disclosureForm');
 
        // Load the PDF from the public path
        $pdfPath = 'public/suppliers/disclosure/' . $filename;
 
 
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
 
    public function ApproveDeclineRequest(Request $request)
    {
 
 
        $action = $request->input('action');
        $comment = $request->input('comment');
 
 
        // Check the value of the "action" field to determine the action
        if ($action === 'approve') {
            // Handle the approve action
            // ...
 
            //Change status in funds table
 
            DB::table('fundsrequest')
                ->where('id', session("fundsId"))
                ->update([
                    'Status' => "Approved",
                    'comment' => $comment
 
                ]);
 
 
            return redirect()->back()->with('StatusChange', 'Request approved.');
 
        } elseif ($action === 'decline') {
            // Handle the decline action
            // ...
 
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
 
        }
 
        // Handle the case where no valid action is found
     
    }
}
 
