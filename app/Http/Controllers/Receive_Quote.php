<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolDistrict;
use App\Models\inbox_school;
use App\Models\RequestFundsModel;
use App\Models\Circuit;
use App\Models\ef48docs;
use App\Models\doc_quote;
use App\Models\School;

use App\Models\capturedsuppliers;
use Barryvdh\Snappy\Facades\SnappyPdf;

class Receive_Quote extends Controller
{
    public function index($requestType, Request $request)
    {


        $emis = Auth::user()->username;
        session(['emis' => $emis]);

        
       

        session(['requestType' => $requestType]);
        $supplierData = DB::table('savedsuppliers')
            ->join('suppliyer', 'savedsuppliers.supplierID', '=', 'suppliyer.Id')
            ->where('savedsuppliers.emis', '=', session('emis'))
            ->where('savedsuppliers.requestType', '=', session('requestType'))
            ->select( 'savedsuppliers.id' , 'suppliyer.Id', 'suppliyer.email', 'suppliyer.CompanyName', 'suppliyer.CompanyAddress', 'suppliyer.CompanyContact') // Add other columns as needed
            ->get();

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
                'capturedsuppliers.Recommended',
                'capturedsuppliers.comment',

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

         //   $supplierRecommended = session('CapturedData')->where('Recommended', "yes")->first();

          //  $recommendedID = $supplierRecommended->custom_id;

          //  session(['recommendedID' => $recommendedID]);
        
           

         $existRecordSupplier = capturedsuppliers::where('savedSupplierID', )->exists();
            session(['supplierData' => $supplierData]);

         $fundsId= inbox_school::where('requestType', session("requestType"))->where('school_emis', session("emis"))->value("funds_request_id");
         $statusRequest= RequestFundsModel::where('id', $fundsId)->value("Status");

         if($statusRequest =="Declined")
         {
            $statusComment= RequestFundsModel::where('id', $fundsId)->value("comment");
         }
         else
         {
            $statusComment= "";
         }

         session(['statusComment' => $statusComment]);
          
        $savedSupplierID= $request->input("hiddenFieldValue");
      
          //Get the savedSupplierIDs
     $savedSupplierID= $request->input("hiddenFieldValue");
     $supplierCaptured =  capturedsuppliers::all();


     
    
   
  //   $isReceivedMinimumQuotes = $request->input("isReceivedMinimumQuotes");
    
 
 
     $showModel= false;
   

     session(['supplierCaptured' => $supplierCaptured]);

     // Generate the comitee form

     $schoolname = School::where('emis', $emis)->value('name');

     session(['schoolname' => $schoolname]);

     $districtId= School::where('emis', $emis)->value('district_id');
     $districtName= SchoolDistrict::where('id', $districtId)->value('district_office');

     $circuitId= School::where('emis', $emis)->value('circuit_id');
     $circuitName= Circuit::where('id', $circuitId)->value('circuit_name');

     $recommendedSupplier = session('CapturedData')->where('Recommended', 'yes')->first();

     $recommendedSupplierName = $recommendedSupplier ? $recommendedSupplier->CompanyName : null;


     $recommendedSupplierAmount = $recommendedSupplier ? $recommendedSupplier->amount : null;

     // Generate the EF48 Form 
       $pdf = SnappyPDF::loadView('Section21_C.Receive_Quote.EF58', [
        'CapturedData' => $CapturedData,
        'emis' => $emis,
        'schoolname' => $schoolname,
        'districtName' => $districtName,
        'circuitName' => $circuitName,
        'recommendedSupplierName' => $recommendedSupplierName,
        'recommendedSupplierAmount' =>  $recommendedSupplierAmount,
        'requestType' =>  session('requestType')
        

    ])->setOption('orientation', 'Landscape')->setOption('page-size', 'A4');
    $pdf->setTimeout(600);
    

    $fileName = uniqid() . "_" . $emis . "_" . "EF58.pdf";

    $pdf->save('public/EF58_unsigned/' . $fileName);  


    //Check if file exists

    $fileEF58Exists=ef48docs::where('school_emis', $emis)->where('requestType', session('requestType'))->exists();



    // INSERT INTO `ef48docs`(`id`, `file_Unsigned`, `school_emis`, `requestType`, `file_Signed`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    if( $fileEF58Exists)
    {
        DB::table('ef48docs')
        ->where('school_emis', $emis )
        ->where('requestType', session('requestType') )
        ->update([
            'file_Unsigned' => $fileName,
        ]);
    }
    else 
    {
    DB::table('ef48docs')
    ->insert([
        'file_Unsigned' => $fileName,
        'school_emis' => $emis,
        'requestType' =>  session('requestType'),
    ]);


    }
    
    
    return view('Section21_C.Receive_Quote.Recieve_Quote')
    ->with('requestType', $requestType)
    ->with('showModel',$showModel )
    ->with('CapturedData' , $CapturedData);

    }
            
    
    //Download EF58 
    public function downloadEF58()
    {
       // $emis = auth()->user()->username;
       // $requestType = session('requestType', 'default_value_if_not_set');

        $filename = ef48docs::where('school_emis', session('emis'))->where('requestType',   session('requestType') )->value('file_Unsigned');

        // Load the PDF from the public path
        $pdfPath = 'public/EF58_unsigned/' . $filename;

        
         // Download the PDF
        return response()->download($pdfPath, $filename);
    }

        

        public function updateRecommended( Request $request)
        {
            
        
            $emis = session("emis");
            $requestType = session("requestType");
        

            $isRecommendedClicked = $request->input('isSubmitRecommend');

   // Now you can use $isCaptured in your controller logic
        if ($isRecommendedClicked == "true")
        {
                $Ef58File = $request->file('fileEF48');

                            
                $fileNamEF58 = uniqid() . '_' . $Ef58File->getClientOriginalName();

                $destinationPath = "public/EF48_Signed";

                $Ef58File->move($destinationPath, $fileNamEF58);

                DB::table('ef48docs')
                ->where('school_emis', session("emis") )
                ->where('requestType', session('requestType') )
                ->update([
                    'file_Signed' => $fileNamEF58,
            ]); 

            $message= "EF58 form successfully submited";


            //Inbox table update
            DB::table('inbox_school')
            ->where('school_emis', $emis)
            ->where('requestType', session("requestType"))
            ->update([
                'status' => 'Quote Received',
                'activity_name' => 'Completed',
            ]);


            $fundsId= inbox_school::where('requestType', session("requestType"))->where('school_emis', session("emis"))->value("funds_request_id");
            DB::table('fundsrequest')
            ->where('id', $fundsId)
            ->update([
                'Status' => 'Pending',
            ]);


        }else
        {


           

     //   $recommendedExists = session('CapturedData')->where('Recommended', "yes")->where('emis', session("emis"))->where('requestType', session("requestType"))->exists();


     $recommendedID = $request->input("recommendedID");
      
     DB::statement("
     UPDATE capturedsuppliers
     INNER JOIN savedsuppliers ON capturedsuppliers.savedSupplierID = savedsuppliers.id
     SET capturedsuppliers.Recommended = 'no'
     WHERE 
       savedsuppliers.emis = :emis
       AND savedsuppliers.requestType = :requestType
 ", [
     
     'emis' => $emis,
     'requestType' => $requestType,
 ]);
    /*   DB::table('capturedsuppliers')
     ->update([
         'Recommended' => "no",

     ]); */
 

     DB::statement("
    UPDATE capturedsuppliers
    INNER JOIN savedsuppliers ON capturedsuppliers.savedSupplierID = savedsuppliers.id
    SET capturedsuppliers.Recommended = 'yes'
    WHERE capturedsuppliers.id = :recommendedID
      AND savedsuppliers.emis = :emis
      AND savedsuppliers.requestType = :requestType
", [
    'recommendedID' => $recommendedID,
    'emis' => $emis,
    'requestType' => $requestType,
]);
    /*  DB::table('capturedsuppliers')
     ->where('id', $recommendedID)
     ->update([
         'Recommended' => "yes",



     ]); */

     $message= "";


        }
         
   
           
          

          
        $value = "true";
        session(['OkNowSuccessAnother' => $value]);
        
        return redirect()->back()
            ->with('activeTab', "tab3")
            ->with('success', $message)
            ->with('OkNowSuccessAnother', session('OkNowSuccessAnother'));

           
        }
    

    public function submitSuppliers( Request $request)
{
    

    $isReceivedMinimumQuotes = $request->input("isReceivedMinimumQuotes");
    session(['isReceivedMinimumQuotes' => $isReceivedMinimumQuotes]);
    
    $value = "true";
    session(['OkNowSuccess' => $value]);
   
   $isCaptured = $request->input('isSubmit');


   // Now you can use $isCaptured in your controller logic
   if ($isCaptured == "true")
   {

        if (session('isReceivedMinimumQuotes') == "false")
        {
            return redirect()->route('chooseSupplier', ['requestType' => session('requestType') , 'MinQuotes' => "false",  'OkNowSuccess' => session('OkNowSuccess')]);
        } 

   } 

  
    

   $showModel= false;
      return redirect()->back()
    ->with('showModel',$showModel )
    ->with('OkNowSuccess', session('OkNowSuccess'));

    
  
   
}

public function CaptureSuppliers(Request $request)
{

    

    $capturedSupplier = capturedsuppliers::where('savedSupplierID', session('itemId'))->exists();

    // Quote supplier upload 

  
    
    if(capturedsuppliers::where('savedSupplierID', session('itemId'))->value('quoteForm') != null)
    {
       

    }
    else
    {
        $request->validate([
            'fileQuote' => 'required|file|mimes:pdf,doc,docx',
        
        ]);

        
        $supplierQuote = $request->file('fileQuote');

        

        $fileNameQuote = uniqid() . '_' . $supplierQuote->getClientOriginalName();

        $destinationPath = "public/suppliers/quotes";

        $supplierQuote->move($destinationPath, $fileNameQuote);
   }




   $IsSBD4FormInserted= capturedsuppliers::where('savedSupplierID', session('itemId'))->value('sbd4Form');
    if( $IsSBD4FormInserted != null &&  $IsSBD4FormInserted != "N/A")
    {

    }
    else
    {
 
            $supplierSBD4 = $request->file('fileSBD4');
            
            if($supplierSBD4 == null )
            {
                $fileNameSBD4= "N/A";
            }
            else 
            {

                $fileNameSBD4 = uniqid() . '_' . $supplierSBD4->getClientOriginalName();

            
                $destinationPath = "public/suppliers/sbd4";

                $supplierSBD4->move($destinationPath, $fileNameSBD4);


                if($capturedSupplier  == true &&   $IsSBD4FormInserted == "N/A")
                {
                    DB::table('capturedsuppliers')
                    ->where('savedSupplierID', session("itemId"))
                    ->update([
                        'sbd4Form' => $fileNameSBD4,
            
                    ]);
                }
            }
    
    }


    $IsDisclosureFormInserted= capturedsuppliers::where('savedSupplierID', session('itemId'))->value('disclosureForm');
    if( $IsDisclosureFormInserted != null &&   $IsDisclosureFormInserted != "N/A")
    {
       
    }
    else
    {
        $supplierDisclosure = $request->file('fileDisclosure');

            if($supplierDisclosure == null )
            {
                $fileNameDisclosure= "N/A";
            }
            else 
            {

                $fileNameDisclosure = uniqid() . '_' . $supplierDisclosure->getClientOriginalName();
                $destinationPath = "public/suppliers/disclosure";

                $supplierDisclosure->move($destinationPath, $fileNameDisclosure);


                    
                if($capturedSupplier == true  &&   $IsDisclosureFormInserted == "N/A")
                {
                    DB::table('capturedsuppliers')
                    ->where('savedSupplierID', session("itemId"))
                    ->update([
                        'disclosureForm' => $fileNameDisclosure,
            
                    ]);
                }

                
            }


    }


    $IsTaxFormInserted= capturedsuppliers::where('savedSupplierID', session('itemId'))->value('taxClearanceForm');
    if( $IsTaxFormInserted != null &&   $IsTaxFormInserted != "N/A")
    {
       // dump("Something");
       // dump($IsTaxFormInserted);

 
    }
    else
    {
        $supplierTax = $request->file('fileTax');
      //  dump("JJJJJJ");


        if($supplierTax == null )
        {
            $fileNameTax= "N/A";
           // dump("Here");

        }
        else 
        {
           // dump("we are here");



            $fileNameTax = uniqid() . '_' . $supplierTax->getClientOriginalName();

         //   dump($fileNameTax);

    
            $destinationPath = "public/suppliers/taxClearance";
        
            $supplierTax->move($destinationPath, $fileNameTax);

 //dump($IsTaxFormInserted);
            if($capturedSupplier == true &&   $IsTaxFormInserted == "N/A")
          {
               DB::table('capturedsuppliers')
             ->where('savedSupplierID', session("itemId"))
             ->update([
               'taxClearanceForm' => $fileNameTax,

                ]);
           }
        }

    
}
    

   

    

    //Amount 
    $orderedAmt=   doc_quote::where('Emis', session("emis"))->where('requestType', session("requestType"))->value("ordered_amt");

    if(session("requestType") =="Textbook")
    {
       $markUpPerc= $request->input("markUp");
       $amount =  $orderedAmt + ( $orderedAmt *   $markUpPerc/100);
    }
    else 
    {
        $amount = number_format($request->input("amtCaptured"), 2, '.', '');


        $markUpPerc = (($amount - $orderedAmt) / $orderedAmt) * 100;


     


    } 

    //comment
    $comment = $request->input('comment');

    //tax clearance 
    $taxValue = $request->input("taxClearanceHidden");

    if($taxValue=="yes")
    {
        $finalTaxVal= "yes";
    }
    else 
    {
        $finalTaxVal= "no";
    }


   

    // Insert into the database 


    if( $capturedSupplier)
    {

        DB::table('capturedsuppliers')
        ->where('savedSupplierID', session("itemId"))
        ->update([
            'amount' =>   $amount,
            'comment' =>    $comment,
            'taxClearance' =>   $finalTaxVal,
            'markUp'=>   $markUpPerc,
          
            
    
    
        ]);
    
    }
    else
    {
    
        DB::table('capturedsuppliers')
        ->insert([
            'quoteForm' => $fileNameQuote,
            'sbd4Form' => $fileNameSBD4,
            'disclosureForm' =>  $fileNameDisclosure,
            'taxClearanceForm' => $fileNameTax,
            'amount' =>   $amount,
            'markUp'=>   $markUpPerc,
            'comment' =>    $comment,
            'taxClearance' =>   $finalTaxVal,
            'savedSupplierID' => session("itemId"),
            


        ]);
    }

    
        return redirect()->route('receiveQuotes', ['requestType' => session('requestType')] );
}




}
