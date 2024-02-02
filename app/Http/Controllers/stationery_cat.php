<?php

namespace App\Http\Controllers;

use App\Models\doc_quote;
use App\Models\School;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\stationeryCatModel;
use App\Models\savedstationeryitems;
use App\Models\inbox_school;
use Illuminate\Support\Facades\Storage;

class stationery_cat extends Controller
{

    public function index($requestType, $idInbox)
    {


        $emis =  Auth::user()->username;
        session(['emis' => $emis]);

        session(['requestType' => $requestType]);
        session(['idInbox' => $idInbox]);


        $stationeryData = stationeryCatModel::paginate(40);
        session(['stationeryData' => $stationeryData]);

        //Saved Stationery Data
        $querySavedItems = savedstationeryitems::where('school_emis', $emis)->get();
        $dataSavedStationery = $querySavedItems;
        session(['dataSavedStationery' => $dataSavedStationery]);

        $searchWord = "";


        $quoteStatus = inbox_school::where('requestType', "Stationery")->where('school_emis', $emis)->value('status');
        session(['quoteStatus' => $quoteStatus]);

        $AllocatedAmt = inbox_school::where('school_emis', $emis)->where('requestType', 'Stationery')->value('allocation');
        session(['AllocatedAmt' => $AllocatedAmt]);

        $quoteData = doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->get();
        $status =   doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->value("status");
        session(['statusStat' => $status]);
        $TotalPages =   doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->value("Total_Pages");
        session(['TotalPagesStat' => $TotalPages]);
        $orderedAmt =   doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->value("ordered_amt");
        session(['orderedAmtStat' => $orderedAmt]);

        session(['quoteData' => $quoteData]);


        return view('Section21_C.RequestQuotation.stationeryCat')
            ->with('requestType', $requestType)
            ->with('emis', $emis)
            ->with('idInbox', $idInbox)
            ->with('searchWord', $searchWord)
            ->with('dataSavedStationery', $dataSavedStationery)
            ->with('stationeryData', $stationeryData);
    }


    public function indexNew($requestType, $idInbox){
        $emis =  Auth::user()->username;
        session(['emis' => $emis]);

        session(['requestType' => $requestType]);
        session(['idInbox' => $idInbox]);


        // $stationeryDataNew = stationeryCatModel::paginate(10);
        // session(['stationeryDataNew' => $stationeryDataNew]);

        //Saved Stationery Data
        $querySavedItemsNew = savedstationeryitems::where('school_emis', $emis)->paginate(10);
        $dataSavedStationeryNew = $querySavedItemsNew;
        session(['dataSavedStationeryNew' => $dataSavedStationeryNew]);

        $searchWord = "";


        $quoteStatus = inbox_school::where('requestType', "Stationery")->where('school_emis', $emis)->value('status');
        session(['quoteStatus' => $quoteStatus]);

        // $AllocatedAmt = inbox_school::where('school_emis', $emis)->where('requestType', 'Stationery')->value('allocation');
        // session(['AllocatedAmt' => $AllocatedAmt]);

        $quoteData = doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->get();
        $status =   doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->value("status");
        session(['statusStat' => $status]);
        $TotalPages =   doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->value("Total_Pages");
        session(['TotalPagesStat' => $TotalPages]);
        // $orderedAmt =   doc_quote::where('Emis', session("emis"))->where('requestType', "Stationery")->value("ordered_amt");
        // session(['orderedAmtStat' => $orderedAmt]);


        $OrdAmountSum = savedstationeryitems::where('school_emis', session("emis"))
        ->sum('TotalPrice');

        $AllocatedAmt = inbox_school::where('school_emis', session("emis"))->where('requestType', "Stationery")->value('allocation');

        session(['quoteData' => $quoteData]);


        return view('Section21_C.RequestQuotation.stationeryCatNew')
            ->with('requestType', $requestType)
            ->with('emis', $emis)
            ->with('idInbox', $idInbox)
            ->with('searchWord', $searchWord)
            ->with('dataSavedStationeryNew', $dataSavedStationeryNew)
            ->with('OrdAmountSum', $OrdAmountSum)
            ->with('AllocatedAmt', $AllocatedAmt);
          //  ->with('stationeryData', $stationeryData);
    }

    public function AddStationery(){
        return view("Section21_C.RequestQuotation.StationeryAdd");
    }


    public function searchStationery(Request $request)
    {
        $requestType = session('requestType', 'default_value_if_not_set');
        $idInbox = session('idInbox', 'default_value_if_not_set');


        $searchWord = $request->input('searchKeyword');
        session(['searchWord' => $searchWord]);

        if ($searchWord != null) {
            $queryCatalogueData = stationeryCatModel::where('Item', 'like', '%' . $searchWord . '%');
            $stationeryData = $queryCatalogueData->paginate(40);
        } else {
            $stationeryData = stationeryCatModel::paginate(40);
        }


        session()->forget('stationeryData');
        session(['stationeryData' => $stationeryData]);

        $emis =  Auth::user()->username;
        session(['emis' => $emis]);

        //Saved Stationery Data
        $querySavedItems = savedstationeryitems::where('school_emis', $emis)->get();
        $dataSavedStationery = $querySavedItems;
        session(['dataSavedStationery' => $dataSavedStationery]);

        return view('Section21_C.RequestQuotation.stationeryCat')
            ->with('requestType', $requestType)
            ->with('emis', $emis)
            ->with('idInbox', $idInbox)
            ->with('searchWord', $searchWord)
            ->with('dataSavedStationery', $dataSavedStationery)
            ->with('stationeryData', $stationeryData);
    }


  

    public function saveCheckedItemsStat(Request $request)
    {

        //  session()->forget('selectedItems');
        $idInbox = session('idInbox', 'default_value_if_not_set');
        $emis = session('emis');
        // Retrieve the new array from the request
        if (session('quoteStatus') != "Quote Created") {
            $newItems = $request->input('selectedItems');

            //Delete items that are unchecked
            $uncheckedItems = explode(',', $request->input('UncheckedItems'));
            foreach ($uncheckedItems as $itemId) {
                savedstationeryitems::where('stationery_id', $itemId)->delete();
            }

            //Check if there is any null items from the newly selected items
            if ($newItems != null) {

                // Validation logic

                $selectedQuantities = $request->input('selectedQuantities');


                $selectedRecords = stationeryCatModel::whereIn('id', $newItems)->get(['id', 'ItemCode', 'Item', 'UnitPrices']);

                $querySavedItems = savedstationeryitems::where('school_emis', $emis)->get();
                $dataSavedTextbook = $querySavedItems;
                session(['dataSavedStationery' => $dataSavedTextbook]);


                try {
                    foreach ($selectedRecords as $record) {

                        $SavedItem = savedstationeryitems::where('item_code', $record->ItemCode)->where('school_emis', $emis)->first();
                        $itemId = $record->id;
                        $price = (float) str_replace(['R', ',', ' '], '', 100.00);
                        $quantity = $selectedQuantities[$itemId];

                        //Check if the item exist, if it does then do an update
                        if ($SavedItem) {

                            DB::table('savedstationeryitems')
                                ->where('item_code', $record->ItemCode)
                                ->update([
                                    'Quantity' => $quantity,
                                    // 'TotalPrice' => $quantity * $price,
                                    'inbox_id' =>   $idInbox,
                                    'stationery_id' => $record->id,
                                    'school_emis' => $emis,
                                ]);
                        } // else the item will be inserted as new record
                        else {
                            $itemId = $record->id;

                            DB::table('savedstationeryitems')
                                ->insert([
                                    'item_code' => $record->ItemCode,
                                    'item_title' => $record->Item,
                                    // 'price'=> $record->UnitPrices,
                                    'Quantity' => $quantity,
                                    // 'TotalPrice' => $quantity*$price,
                                    'inbox_id' =>   $idInbox,
                                    'stationery_id' => $record->id,
                                    'school_emis' => $emis,
                                ]);
                        }
                    }
                } catch (\Exception $e) {
                }
            }

            session()->forget('dataSavedStationery');
            $querySavedItems = savedstationeryitems::where('school_emis', $emis)->get();
            $dataSavedTextbook = $querySavedItems;
            session(['dataSavedStationery' => $dataSavedTextbook]);


            $isNextClicked = $request->input('nextPage') === 'true';

            // Check if the "Previous" button was clicked
            $isPreviousClicked = $request->input('previousPage') === 'true';

            // Now, you can perform logic based on these flags
            if ($isNextClicked) {

                $currentPage = session('stationeryData')->currentPage(); // Get the current page number
                $nextPage = $currentPage + 1;

                $nextPageUrl = route('searchStationery', [
                    'page' =>   $nextPage, // Assuming $textbooksData is a paginator
                    'searchWord' => session('searchWord'),
                ]);
                session()->forget('selectedItems');
                return redirect($nextPageUrl);
            } elseif ($isPreviousClicked) {

                $currentPage = session('stationeryData')->currentPage(); // Get the current page number
                $previousPage = $currentPage - 1;

                $previousPageUrl = route('searchStationery', [
                    'page' =>   $previousPage, // Assuming $textbooksData is a paginator
                    'searchWord' => session('searchWord'),
                ]);
                session()->forget('selectedItems');
                return redirect($previousPageUrl);
            }

            return redirect()->route('stationeryCat', ['requestType' => "Stationery", 'idInbox' => $idInbox]);
        }
    }


    public function saveCheckedItemsStatNew(Request $request)
    {

       
        $idInbox = session('idInbox');

        $emis = session('emis');
        // Retrieve the new array from the request
            $newItems = $request->input('selectedItems');


            if ($newItems != null) {

                // Validation logic

                $selectedQuantities = $request->input('selectedQuantities');
               // dump($selectedQuantities);

               // $selectedRecords = stationeryCatModel::whereIn('id', $newItems)->get(['id', 'ItemCode', 'Item', 'UnitPrices']);

                $querySavedItems = savedstationeryitems::where('school_emis', $emis)->paginate(10);
                $dataSavedTextbookNew = $querySavedItems;
                session(['dataSavedStationeryNew' => $dataSavedTextbookNew]);

                 $OrdAmountSum = savedstationeryitems::where('school_emis', session("emis"))
        ->sum('TotalPrice');

        $AllocatedAmt = inbox_school::where('school_emis', session("emis"))->where('requestType', "Stationery")->value('allocation');

                try {
                    foreach ($newItems as $itemCode) {

                      //$Quantityu = $request->input('selectedQuantities.' . $itemCode);

                      $quantity = $selectedQuantities[$itemCode];


                      //  dump($quantity);

                        //Check if the item exist, if it does then do an update
                      //  if ($SavedItem) {

                            DB::table('savedstationeryitems')
                                ->where('item_code', $itemCode)
                                ->update([
                                    'Quantity' => $quantity,

                                ]);
                       // } // else the item will be inserted as new record

                    }
                } catch (\Exception $e) {
                }
            }

         //   session()->forget('dataSavedStationery');
            $querySavedItems = savedstationeryitems::where('school_emis', $emis)->paginate(10);
            $dataSavedTextbookNew = $querySavedItems;
            session(['dataSavedStationeryNew' => $dataSavedTextbookNew]);


            $isNextClicked = $request->input('nextPage') === 'true';

            // Check if the "Previous" button was clicked
            $isPreviousClicked = $request->input('previousPage') === 'true';

            // Now, you can perform logic based on these flags
            if ($isNextClicked) {

                $currentPage = session('dataSavedStationeryNew')->currentPage(); // Get the current page number
                $nextPage = $currentPage + 1;

                $nextPageUrl = route('stationeryCatNew', [
                    'page' =>   $nextPage, // Assuming $textbooksData is a paginator
                    'requestType' => "Stationery",
                    'emis' => $emis,
                    'idInbox' => $idInbox,
                    'OrdAmountSum' => $OrdAmountSum,
                    'AllocatedAmt' => $AllocatedAmt
                ]);
                session()->forget('selectedItems');
                return redirect($nextPageUrl);
            } elseif ($isPreviousClicked) {

                $currentPage = session('dataSavedStationeryNew')->currentPage(); // Get the current page number
                $previousPage = $currentPage - 1;

                $previousPageUrl = route('stationeryCatNew', [
                    'page' =>   $previousPage, // Assuming $textbooksData is a paginator
                    'requestType' => "Stationery",
                    'emis' => $emis,
                    'idInbox' => $idInbox,
                    'OrdAmountSum'=> $OrdAmountSum,
                    'AllocatedAmt' => $AllocatedAmt
                ]);
                session()->forget('selectedItems');
                return redirect($previousPageUrl);
            }

         //   return redirect()->route('dataSavedStationeryNew', ['requestType' => "Stationery", 'idInbox' => $idInbox]);

           return view('Section21_C.RequestQuotation.stationeryCatNew')
            ->with('requestType', "Stationery")
          ->with('emis', $emis)
           ->with('idInbox', $idInbox)
        ->with('dataSavedStationeryNew', session('dataSavedStationeryNew'))
        ->with('OrdAmountSum', $OrdAmountSum)
        ->with('AllocatedAmt', $AllocatedAmt);


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

    public function SaveUnitPriceStationery(Request $request)
    {





        

        //  session()->forget('selectedItems');
       // $idInbox = session('idInbox', 'default_value_if_not_set');
        $emis = session('Emis');
        $fundsId = session('fundsId');
        // Retrieve the new array from the request

        $selectedItems  = $request->input('selectedItems');

        $CheckVal  = $request->input('CheckVal');

        $RecommendedAmount = session('RecommendedAmout');




        $isNextClicked = $request->input('nextPage') === 'true';
        $isPreviousClicked = $request->input('previousPage') === 'true';

       // dump("Nextpage" . $isNextClicked);

       // dump("Previous" . $isPreviousClicked);

        // Now, you can perform logic based on these flags
        if ($isNextClicked) {
            $currentPage = session('dataSavedStationery')->currentPage(); // Get the current page number
            $nextPage = $currentPage + 1;

            $nextPageUrl = route('AdminCaptureStatUnitPrice', [
                'RequestTypes' => "Stationery",
                'Emis' => $emis,
                 'fundsId' => $fundsId,
                 'page' => $nextPage, // Assuming $textbooksData is a paginator
                // 'searchWord' => session('searchWord'),
            ]);

            session()->forget('selectedItems');

            
            DB::table('inbox_school')
            ->where('school_emis', $emis)
            ->where('requestType', 'Stationery')
            ->update([
                'ReworkComment' => null
            ]);

            return redirect($nextPageUrl);
        } elseif ($isPreviousClicked) {
            $currentPage = session('dataSavedStationery')->currentPage(); // Get the current page number
            $previousPage = $currentPage - 1;

            $previousPageUrl = route('AdminCaptureStatUnitPrice', [
                'RequestTypes' => "Stationery",
                'Emis' => $emis,
                 'fundsId' => $fundsId,
                 'page' => $previousPage,
            ]);

            DB::table('inbox_school')
            ->where('school_emis', $emis)
            ->where('requestType', 'Stationery')
            ->update([
                'ReworkComment' => null
            ]);
            
          //  session()->forget('selectedItems');
            return redirect($previousPageUrl);
        }



       $Comment = "The aggregate unit total price captured does not align with the prescribed amount from the recommended supplier : R".$RecommendedAmount;

        if($CheckVal === "true"){
            DB::table('inbox_school')
            ->where('school_emis', $emis)
            ->where('requestType', 'Stationery')
           ->update([
            'status' => "Quote Requested",
               'activity_name' => "Receive Quote",
                'ReworkComment' => $Comment
       ]);


         return redirect()->back()->with('StatusChange', 'Request Failed.');
    //              // return redirect()->route('AdminCaptureStatUnitPrice', ['RequestTypes' => "Stationery", 'Emis' => $emis, 'fundsId' => $fundsId]);
         }

        $quantity  = $request->input('SelectedQuantity');

      try {

          foreach ($selectedItems as $itemCode) {
            //  dump("Hwere");
           // Retrieve the unit price for the current item
            $unitPrice = $request->input('selectedUnitPrice.' . $itemCode);
             //   dump($unitPrice);

                 $itemQuantity = $quantity[$itemCode];
                 // Update the price in the database
            DB::table('savedstationeryitems')
          ->where('item_code', $itemCode)
         ->where('school_emis', $emis)
          ->update([
             'price' => $unitPrice,
            'TotalPrice' => $itemQuantity * $unitPrice
         ]);
            }


         DB::table('inbox_school')
      ->where('school_emis', $emis)
      ->where('requestType', 'Stationery')
   ->update([
            'ReworkComment' => null
        ]);

   return redirect()->route('AdminCaptureStatUnitPrice', ['RequestTypes' => "Stationery", 'Emis' => $emis, 'fundsId' => $fundsId]);
    } catch (\Exception $e) {
       }


       


        
    }



    //Delete saved stationery item
    public function deleteStationeryItem(Request $request)
    {

        $id = $request->input('DelID');


        // Delete the record with the specified ISBN
        $emis = session('emis');
        $result = savedstationeryitems::where('id', $id)->delete();

        $querySavedItems = savedstationeryitems::where('school_emis', $emis)->get();
        $dataSavedTextbook = $querySavedItems;
        session(['dataSavedStationery' => $dataSavedTextbook]);

        if ($result) {
            return redirect()->back()->with([
                'success' => 'Item Deleted Successfully!',
                'activeTab' => 'tab3', // Set the active tab here
            ]);
        } else {
            return redirect()->back()->with([
                'success' => 'Item Deleted Successfully!',
                'activeTab' => 'tab3', // Set the active tab here
            ]);
        }
    }

    // Update status once submit button is clicked
    public function submitSavedItems(Request $request)
    {

        $idInbox = session('idInbox', 'default_value_if_not_set');

        //Update the inbox_school table
        try {
            DB::table('inbox_school')
                ->where('id',  $idInbox)
                ->update([
                    'status' => 'Quote Created',
                    'activity_name' => 'Request Quote',
                ]);
            return redirect()->route('inboxSchool');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }


    // Update status once submit button is clicked
    public function submitSavedItemsNew(Request $request)
    {

        $idInbox = session('idInbox', 'default_value_if_not_set');
        $emis = session('emis');

        //Update the inbox_school table
        try {
            DB::table('inbox_school')
                ->where('school_emis',  $emis)
                ->where('requestType',"Stationery" )
                ->update([
                    'status' => 'Quote Received',
                    'activity_name' => 'Completed',
                ]);
            return redirect()->route('inboxSchool');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function generateQuoteStationery(Request $request)
    {

        set_time_limit(0); // Set to the desired time limit in seconds

        $emis = Auth::user()->username;

        $remainingDigits = substr($emis, 3);

        $requestType = session('requestType', 'default_value_if_not_set');
        $idInbox = session('idInbox', 'default_value_if_not_set');
        $querySavedItems = savedstationeryitems::where('school_emis', $emis)->get();
        $dataSavedStationery = $querySavedItems;

        $schoolname = School::where('emis', $emis)->value('name');

        $pdf = SnappyPdf::loadView('Section21_C.RequestQuotation.GeneratePdfStationery', [
            'dataSavedStationery' => $dataSavedStationery,
            'emis' => $remainingDigits,
            'schoolname' => $schoolname
        ])->setOption('orientation', 'landscape')->setOption('page-size', 'A4');


        $pages = ceil($dataSavedStationery->count() / 15);
        $pdf->setTimeout(600);

        $fileName = uniqid() . "_" . $emis . "_" . "StationeryQuote.pdf";

        $pdf->save('public/GenPdfStat/' . $fileName);
        session(['status' => 'complete']);


        $orderedAmount = $request->input("orderedAmount");

        DB::table('doc_quote')
            ->insert([
                'Emis' => $emis,
                'FileName' => $fileName,
                'requestType' =>  $requestType,
                'Total_Pages' => $pages,
                'ordered_amt' => $orderedAmount,
                'status' => "Generated"

            ]);


        session(['status' => 'Generated']);


        return redirect()->route('stationeryCat', ['requestType' => "Stationery", 'idInbox' => $idInbox])
            ->with(['activeTab' => 'tab3', 'pages' => $pages]);
    }


    public function viewQuotesStat()
    {
        $emis = auth()->user()->username;
        $requestType = session('requestType', 'default_value_if_not_set');
        $idInbox = session('idInbox', 'default_value_if_not_set');

        $filename = doc_quote::where('Emis', $emis)->where('requestType',   $requestType)->value('FileName');

        // Load the PDF from the public path
        $pdfPath = 'public/GenPdfStat/' . $filename;

        // Stream the PDF to the browser
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function quoteTextbookDeleteStationery()
    {
        $emis = auth()->user()->username;
        $requestType = session('requestType', 'default_value_if_not_set');
        $filename = doc_quote::where('Emis', $emis)->where('requestType',   "Stationery")->value('FileName');


        // Delete the record based on the condition
        doc_quote::where('emis', $emis)->where('requestType', "Stationery")->delete();

        if ($filename) {
            // Delete the file using Laravel's file system methods (assuming public disk)
            Storage::disk('public')->delete('GenPdf/' . $filename);
        }


        return redirect()->back()->with(['activeTab' => 'tab3']);
    }
}
