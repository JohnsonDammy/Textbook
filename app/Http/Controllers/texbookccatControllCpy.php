<?php

namespace App\Http\Controllers;
use App\Jobs\GeneratePdf;
use App\Models\inbox_school;
use App\Models\School;
use App\Models\doc_quote;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

use Barryvdh\Snappy\Facades\SnappyPdf;

use App\Models\textbookCatModel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\savedtextbookitems;


USE PDF;

use Illuminate\Http\Request;

class textbook_cat extends Controller
{
    public function index($requestType,$idInbox)
    {

     
      // Set session variables
       
        session()->forget('schoolLevel');
        /* if(session('status') != "complete")
        {
        session(['status' => "In Progress"]);
        } */

        
        session()->forget('dataSavedTextbook');
        session()->forget('textbooksData');
        session()->forget('emis');
        session(['requestType' => $requestType]);
        session(['idInbox' => $idInbox]);

       
        $quoteStatus= inbox_school::where('Id', $idInbox)->value('status');
        session(['quoteStatus' => $quoteStatus]);

        //Set the default values of dropdown when page loads
        session(['selectedGrade' => 'default']);
        session(['selectedSubject' => 'default']);
        session(['selectedPublisher' => 'default']);
        
        
        $data = inbox_school::all();
       
        //Get all the SavedItems for textbook
      
        //Get Items list for the subject and Publisher dropdownList
    
        $emis =  Auth::user()->username;
        session(['emis' => $emis]);
        $schoolLevel = School::where('emis', $emis)->value('level_id');


        $querySavedItems= savedtextbookitems::where('school_emis', $emis)->get();
        $dataSavedTextbook=$querySavedItems;
        session(['dataSavedTextbook' => $dataSavedTextbook]);

       // session(['status' => 'In Progress']);

        //Get School Level Filter default textbook catalogue based on school level (Grade Range)

        if( $schoolLevel == 1)
        {
            $queryCatalogueData = textbookCatModel::whereBetween('Grade', [1, 7]);
                                      
        }
        elseif( $schoolLevel == 2)
        {
            $queryCatalogueData = textbookCatModel::whereBetween('Grade', [8, 12]);
        }
        else 
        {
            $queryCatalogueData = textbookCatModel::whereBetween('Grade', [1, 12]);
        }

        $textbooksData = $queryCatalogueData->paginate(50);
        session(['textbooksData' => $textbooksData]);

        
        session(['schoolLevel' => $schoolLevel]);
        $Subjects = textbookCatModel::distinct()->pluck('Subject');
        $Publishers = textbookCatModel::distinct()->pluck('Publisher');
        $status ="In Progress";

        return view('Section21_C.RequestQuotation.textbookCat')
        ->with('data', $data)
        ->with('requestType', $requestType)
        ->with('idInbox', $idInbox)
        ->with('emis', $emis)
        ->with('schoolLevel', $schoolLevel)
        ->with('Subjects', $Subjects)
        ->with('Publishers', $Publishers)
        ->with('Publishers', $Publishers)
        ->with('dataSavedTextbook', $dataSavedTextbook)
        ->with('textbooksData', $textbooksData);
    }

    public function filterCatalogue(Request $request)
    {
       
        $data = inbox_school::all();
        $messageLoaded="";
        $emis =  Auth::user()->username;
        $textbooksData = session('textbooksData');
        $dataSavedTextbook =  session('dataSavedTextbook');
        $requestType = session('requestType', 'default_value_if_not_set');
        $schoolLevel = session('schoolLevel', 'default_value_if_not_set');
        $idInbox = session('idInbox', 'default_value_if_not_set');

        //Set dropdown filters 
        $Subjects = array_filter(textbookCatModel::distinct()->pluck('Subject')->toArray());
        $Publishers = array_filter(textbookCatModel::distinct()->pluck('Publisher')->toArray());
        $subjectSelected = $request->input('Subject');
        $publisherSelected = $request->input('Publisher');
        $gradeSelected =  $request->input('Grade');

           // Store the selected filter values in the session
        session(['selectedGrade' => $gradeSelected]);
        session(['selectedSubject' => $subjectSelected]);
        session(['selectedPublisher' => $publisherSelected]);


          
     

        $avoidFilter = false;
       
        if ($subjectSelected == "default" && $publisherSelected == "default" && $gradeSelected == "default" )
        {
            $avoidFilter = true;
        }
        elseif($subjectSelected == "default" && $publisherSelected == "default")
        {
            $query = textbookCatModel::where('Grade', $gradeSelected);
        }
        elseif($gradeSelected == "default" && $publisherSelected == "default")
        {
            $query = textbookCatModel::where('Subject', $subjectSelected);
        }
        elseif($gradeSelected == "default" && $subjectSelected == "default")
        {
            $query = textbookCatModel::where('Publisher', $publisherSelected);
        }
        elseif($subjectSelected == "default" )
        {
        
           $query = textbookCatModel::where('Publisher', $publisherSelected)
                                      ->where('Grade', $gradeSelected);
                             
        }
        elseif($publisherSelected == "default")
        {
            $query = textbookCatModel::where('Subject', $subjectSelected)
                                    ->where('Grade', $gradeSelected);
                             
        }
        elseif ($gradeSelected == "default")
        {
            $query = textbookCatModel::where('Subject', $subjectSelected)
                                     ->where('Publisher', $publisherSelected);
        }
        else
        {
            $query = textbookCatModel::where('Subject', $subjectSelected)
                               ->where('Publisher',  $publisherSelected)
                               ->where('Grade', $gradeSelected);
        }

    
             $queryParams = [
                'Subject' => $subjectSelected,
                'Publisher' => $publisherSelected,
                'Grade' => $gradeSelected,
            ]; 
       

        if($avoidFilter)
        {
            if( $schoolLevel == 1)
            {
                $queryCatalogueData = textbookCatModel::whereBetween('Grade', [1, 7]);
                                          
            }
            elseif( $schoolLevel == 2)
            {
                $queryCatalogueData = textbookCatModel::whereBetween('Grade', [8, 12]);
            }
            else 
            {
                $queryCatalogueData = textbookCatModel::whereBetween('Grade', [1, 12]);
            }
    
            session()->forget('textbooksData');
            $textbooksData = $queryCatalogueData->paginate(30);
            session(['textbooksData' => $textbooksData]);
        }
        else 
        {
            session()->forget('textbooksData');
            $textbooksData = $query->paginate(30)->withQueryString();
            session(['textbooksData' => $textbooksData]);
        }

     
        //Return the view 
        return view('Section21_C.RequestQuotation.textbookCat',compact('data','textbooksData','requestType','Subjects','Publishers','idInbox', 'messageLoaded' , 'dataSavedTextbook','schoolLevel','emis'));
    }


    public function saveCheckedItems(Request $request)
    {

      //  session()->forget('selectedItems');
        $idInbox = session('idInbox', 'default_value_if_not_set');
        $emis = session('emis');


        // Retrieve the new array from the request
        if(session('quoteStatus') != "Quote Created")
        {
        $newItems = $request->input('selectedItems');

        //Delete items that are unchecked
         $uncheckedItems = explode(',', $request->input('UncheckedItems'));
        foreach ($uncheckedItems as $itemId) 
        {
            savedtextbookitems::where('textbook_id', $itemId)->delete();
        } 

        //Testing purpose
         /*  for ($i = 0; $i < 1000; $i++)
        {
            DB::table('savedtextbookitems')
                        ->insert([
                            'Title' => "Ella",
                            'ISBN' =>"88888888888888",
                            'Price' => 20,
                            'Quantity' => 2,
                            'TotalPrice' => 100, 
                            'inbox_id'=>   1,
                            'textbook_id' => 2,
                            'school_emis' =>"777777777",
                        ]);
        }    
         */
         
        //Check if there is any null items from the newly selected items
       if($newItems != null)
        {

                // Validation logic
             
                $selectedQuantities = $request->input('selectedQuantities');
                $selectedRecords = textbookCatModel::whereIn('id', $newItems)->get(['id', 'Title', 'ISBN', 'Price']);

                $querySavedItems= savedtextbookitems::where('school_emis', $emis)->get();
                $dataSavedTextbook=$querySavedItems;
                session(['dataSavedTextbook' => $dataSavedTextbook]);

       
            
            try
            { 
                foreach ($selectedRecords as $record) {

                    $SavedItem = savedtextbookitems::where('ISBN', $record->ISBN)->first(); 
                    $itemId = $record->id;
                    $price = (float) str_replace(['R', ',', ' '], '', $record->Price);
                    $quantity = $selectedQuantities[$itemId];

                    //Check if the item exist, if it does then do an update 
                    if($SavedItem)
                    {
                        
                    DB::table('savedtextbookitems')
                    ->where('ISBN',$record->ISBN)
                    ->update([
                        'Quantity' => $quantity,
                        'TotalPrice' => $quantity*$price,
                        'inbox_id'=>   $idInbox,
                        'textbook_id' => $record->id,
                        'school_emis' => $emis,
                    ]);

                    }// else the item will be inserted as new record
                    else
                    {
                    $itemId = $record->id;
            
                    DB::table('savedtextbookitems')
                        ->insert([
                            'Title' => $record->Title,
                            'ISBN' => $record->ISBN,
                            'Price' => $record->Price,
                            'Quantity' => $quantity,
                            'TotalPrice' => $quantity*$price, 
                            'inbox_id'=>   $idInbox,
                            'textbook_id' => $record->id,
                            'school_emis' => $emis,
                        ]);
                    }
                }

            }
            catch (\Exception $e)
            {

            }
       }

            session()->forget('dataSavedTextbook');
            $querySavedItems= savedtextbookitems::where('school_emis', $emis)->get();
            $dataSavedTextbook=$querySavedItems;
            session(['dataSavedTextbook' => $dataSavedTextbook]);


            $isNextClicked = $request->input('nextPage') === 'true';

            // Check if the "Previous" button was clicked
            $isPreviousClicked = $request->input('previousPage') === 'true';
        
            // Now, you can perform logic based on these flags
            if ($isNextClicked) {

                $currentPage = session('textbooksData')->currentPage(); // Get the current page number
                $nextPage = $currentPage + 1;
    
                $nextPageUrl = route('filterTextbook', [
                    'page' =>   $nextPage, // Assuming $textbooksData is a paginator
                    'Subject' => session('selectedSubject'),
                    'Publisher' => session('selectedPublisher'),
                    'Grade' => session('selectedGrade'),
                ]);
               // session()->forget('selectedItems');
                return redirect($nextPageUrl);
            } elseif ($isPreviousClicked) {

                $currentPage = session('textbooksData')->currentPage(); // Get the current page number
                $previousPage = $currentPage - 1;
    
                $previousPageUrl = route('filterTextbook', [
                    'page' =>   $previousPage, // Assuming $textbooksData is a paginator
                    'Subject' => session('selectedSubject'),
                    'Publisher' => session('selectedPublisher'),
                    'Grade' => session('selectedGrade'),
                ]);
            //    session()->forget('selectedItems');
                return redirect($previousPageUrl);
            }
         
            return redirect()->route('textbookCat', ['requestType' => "Textbook", 'idInbox' => $idInbox]);

          
        }
    }

        

       
        public function deleteTextbookItem($id)
     {
            
           // Delete the record with the specified ISBN
           $emis = session('emis');

           $result = savedtextbookitems::where('id', $id)->delete();

           $querySavedItems= savedtextbookitems::where('school_emis', $emis)->get();
           $dataSavedTextbook=$querySavedItems;
           session(['dataSavedTextbook' => $dataSavedTextbook]);
           
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


    public function submitSavedItems(Request $request) 
    {
                 
            $idInbox = session('idInbox', 'default_value_if_not_set');
           
         
            try{
            DB::table('inbox_school')
                ->where('id',  $idInbox)
                ->update([
                    'status' => 'Quote Created',
                    'activity_name' => 'Choose Suppliers',
                ]);
                return redirect()->route('inboxSchool');
            }catch(Exception $e)
            {
                return redirect()->back();
            }
    }


        
    public function generatePdf()
       {
    
    
    
           set_time_limit(0); // Set to the desired time limit in seconds
    
           $emis = Auth::user()->username;
    
           $remainingDigits = substr($emis, 3);
    
           $querySavedItems = savedtextbookitems::where('school_emis', $emis)->get();
           $dataSavedTextbook = $querySavedItems;
    
           $schoolname = School::where('emis', $emis)->value('name');
    
           $pdf = SnappyPDF::loadView('Section21_C.RequestQuotation.GenPdf', [
               'dataSavedTextbook' => $dataSavedTextbook,
               'emis' => $remainingDigits,
               'schoolname' => $schoolname
           ])->setOption('orientation', 'landscape')->setOption('page-size', 'A4');
    
    
           $pages = ceil($dataSavedTextbook->count() / 15);
           $pdf->setTimeout(600);
    
           $fileName = uniqid() . "_" . $emis . "_" . "TextbookQuote.pdf";
    
           $pdf->save('public/GenPdf/' . $fileName);
           session(['status' => 'complete']);
    
           $requestType = session('requestType', 'default_value_if_not_set');
    
           DB::table('doc_quote')
               ->insert([
                   'Emis' => $emis,
                   'FileName' => $fileName,
                   'requestType' =>  $requestType
    
               ]);
    
    
           session(['status' => 'Generated']);
    
           return redirect()->route('textbookCat', ['requestType' => "Textbook", 'idInbox' => 1])
               ->with(['activeTab' => 'tab3', 'pages' => $pages]);
    
    
       }
    
    
       public function viewQuotes()
       {
           $emis = auth()->user()->username;
           $requestType = session('requestType', 'default_value_if_not_set');
    
           $filename = doc_quote::where('Emis', $emis)->where('requestType',   $requestType )->value('FileName');
    
           // Load the PDF from the public path
           $pdfPath = 'public/GenPdf/' . $filename;
    
           // Stream the PDF to the browser
           return response()->file($pdfPath, [
               'Content-Type' => 'application/pdf',
               'Content-Disposition' => 'inline; filename="' . $filename . '"',
           ]);
    
    
    
       }


    
       public function quoteTextbookDelete()
       {
           $emis = auth()->user()->username;
           $requestType = session('requestType', 'default_value_if_not_set');
           $fileName = doc_quote::where('emis', $emis)->where('requestType',   $requestType )->value('FileName');
    
           // Delete the record based on the condition
           doc_quote::where('emis', $emis)->where('requestType',   $requestType )->delete();
    
           if ($fileName) {
               // Delete the file using Laravel's file system methods (assuming public disk)
               Storage::disk('public')->delete('GenPdf/' . $fileName);
           }
           session(['status' => 'Not Generated']);
    
           return redirect()->back()->with(['activeTab' => 'tab3']);
    
       }







        
public function ShowPdf(){

    $emis = Auth::user()->username;

    $remainingDigits = substr($emis, 3);

    $querySavedItems = savedtextbookitems::where('school_emis', $emis)->get();
    $dataSavedTextbook = $querySavedItems;

    $schoolname = School::where('emis', $emis)->value('name');
  return view('Section21_C.RequestQuotation.committee')
    ->with('emis', $emis)
    ->with('remainingDigits', $remainingDigits)
    ->with('dataSavedTextbook', $dataSavedTextbook)
    ->with('schoolname', $schoolname);
}

public function genPdfExample(){
    
    $pdf = SnappyPDF::loadView('Section21_C.RequestQuotation.committee')->setOption('orientation', 'landscape')->setOption('page-size', 'A4');
    $pdf->setTimeout(600);

    // Use inline() to stream the PDF to the browser
    return $pdf->inline('committee_example.pdf');
}

    


}
