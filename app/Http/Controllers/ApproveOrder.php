<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\OrderLetterModel;
use App\Models\School;
use App\Models\UploadOrderLetterModel;
use App\Helpers\SendEmail;
use App\Models\capturedsuppliers;
use App\Models\savedsuppliers;


class ApproveOrder extends Controller
{
    //
    public function index(){

        $emis = session('emis');
    
        $school_principal = School::where('emis',  $emis )->value('school_principal');

        //Captured Supplier Table
        $CapturedData = DB::table('suppliyer')
            ->select(
                'suppliyer.email',
                'capturedsuppliers.id AS custom_id', // Use the AS keyword to give a custom name
                'suppliyer.CompanyName',
                'suppliyer.Id',
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
            ->where('savedsuppliers.requestType', '=', session("requestType"))
            ->where('savedsuppliers.emis', '=', session("emis"))
            ->where('capturedsuppliers.Recommended', '=', "yes")
            ->get();
 
        session(['CapturedData' => $CapturedData]);
        
//resources\views\Section21_C\AdminSupplierOrder\OrderLatter.blade.php
$DeliveryDate = OrderLetterModel::where('EMIS', session('emis'))->where('RequestType',   session('requestType') )->value('DeliveryDate');
$FailDate = OrderLetterModel::where('EMIS', session('emis'))->where('RequestType',   session('requestType') )->value('FailDate');

$SupplierID = savedsuppliers::where('emis', session('emis'))->where('requestType',   session('requestType') )->value('id');

$QuoteDate = capturedsuppliers::where('savedSupplierID', $SupplierID)->value('Date');

$pdf = SnappyPDF::loadView('Section21_C.AdminSupplierOrder.OrderLatter', [
            'CapturedData' => $CapturedData,
            'school_principal' => $school_principal,
            'requestType' =>  session('requestType'),
            'DeliveryDate' => $DeliveryDate,
            'FailDate' => $FailDate,
            'QuoteDate' => $QuoteDate
            
    
        ])->setOption('orientation', 'Portrait')->setOption('page-size', 'A4');
        $pdf->setTimeout(600);
        
    
        $fileName = uniqid() . "_" . $emis . "_" . "Orderletter.pdf";

        //INSERT INTO `orderform`(`Id`, `EMIS`, `RequestType`, `FileName`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    
        $pdf->save('OrderFormLetter/' . $fileName);  

         // Insert selected suppliers in database
         $existingOrderLetter = OrderLetterModel::where('EMIS',  $emis )->where('RequestType', session('requestType'))->exists();
         if( $existingOrderLetter)
         {
             DB::table('orderform')
             ->where('EMIS',  session('emis') )->where('RequestType', session('requestType'))
             ->update([
             'FileName' => $fileName,
                
             ]);
         }
         else
         {
             DB::table('orderform')
             ->insert([
                 'EMIS' => session('emis'),
                 'RequestType' => session('requestType'),
                 'FileName' => $fileName,
                 
             ]);
        }
        
        return view('Section21_C.AdminSupplierOrder.SupplierOrder');
    }


     //Download EF58 
     
     public function OrderLetter()
     {
        // $emis = auth()->user()->username;
        // $requestType = session('requestType', 'default_value_if_not_set');
 
         $filename = OrderLetterModel::where('EMIS', session('emis'))->where('RequestType',   session('requestType') )->value('FileName');
 
         // Load the PDF from the public path
         $pdfPath = 'OrderFormLetter/' . $filename;
 
         
          // Download the PDF
         return response()->download($pdfPath, $filename);
     }


     //INSERT INTO `submitorderedform`(`Id`, `Emis`, `SupplierID`, `RequestType`, `SignedOrderedUploadForm`, `DeliveryDate`, `FailDate`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')
     public function UploadOrderForm(Request $request){
        $UploadSignedDoc = $request->file('fileOrder');
        $emis = session('emis');

        $FailDate = $request->input('FailDate');
        $deliveryDate = $request->input('deliveryDate');
        $SupplierID = $request->input('SupplierID');
   
        $fileName = "SignOrderForm".uniqid() . '_' . $UploadSignedDoc->getClientOriginalName();
   
       $destinationPath='OrderFormLetter/';   
             $UploadSignedDoc->move( $destinationPath, $fileName);
        $fileToSent= 'OrderFormLetter/'.$fileName;


//INSERT INTO `submitorderedform`(`Id`, `Emis`, `SupplierID`, `RequestType`, `SignedOrderedUploadForm`, `DeliveryDate`, `FailDate`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')
        $existingOrderLetter = UploadOrderLetterModel::where('EMIS',  $emis )->where('RequestType', session('requestType'))->exists();
        if( $existingOrderLetter)
        {
            DB::table('submitorderedform')
            ->where('EMIS',  $emis )->where('RequestType', session('requestType'))
            ->update([
            'SignedOrderedUploadForm' => $fileName,
            ]);

        }
        else
        {
            DB::table('submitorderedform')
            ->insert([
                'EMIS' => session('emis'),
                'SupplierID' => $SupplierID,
                'RequestType' => session('requestType'),
                'SignedOrderedUploadForm' => $fileName,
                'DeliveryDate' => $deliveryDate,
                'FailDate' => $FailDate

            ]);
       }



       $existingOrderLetter = OrderLetterModel::where('EMIS',  $emis )->where('RequestType', session('requestType'))->exists();
       if($existingOrderLetter)
       {
           DB::table('orderform')
           ->where('EMIS',  session('emis') )->where('RequestType', session('requestType'))
           ->update([
           'DeliveryDate' => $deliveryDate,
              
           ]);
       }
     
      
       
       $email= $request->input("Email");
       $schoolname = School::where('emis', session("emis"))->value('name');
       SendEmail::sendRecommendedSupplierMail(session("requestType"),$schoolname, $email, $fileToSent);

       
       $sucessEmail = true;
       session(['sucessEmail' => $sucessEmail]);


       return back();


     }
 


     public function updateDeliveryDate(Request $request)
     {
        $emis = session('emis');

         // Retrieve the date from the request
         $deliveryDate = $request->input('deliveryDate');
         $TheClosingDate = $request->input('closingDates');
         $existingOrderLetter = OrderLetterModel::where('EMIS',  $emis )->where('RequestType', session('requestType'))->exists();
         if($existingOrderLetter)
         {
             DB::table('orderform')
             ->where('EMIS',  session('emis') )->where('RequestType', session('requestType'))
             ->update([
             'DeliveryDate' => $deliveryDate,
             'FailDate' => $TheClosingDate
                
             ]);
         }
         return response()->json(['message' => 'Date updated successfully']);
     }
         
}
