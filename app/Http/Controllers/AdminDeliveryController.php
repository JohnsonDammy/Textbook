<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommitteeModel;
use App\Models\inbox_school;
use App\Models\deliveryCapture;
use App\Models\deliveryselection;

use App\Models\textbookCatModel;
use App\Models\stationeryCatModel;

use App\Models\savedtextbookitems;
use App\Models\AdminSavedTextbookCapturedValueModel;
use App\Models\AdminSavedStationeryCapturedValueModel;

use Illuminate\Database\Eloquent\Model;

use App\Models\School;
use App\Models\DeliveryModel;
use App\Models\doc_quote;
use App\Models\schoolsModel;
use App\Models\savedstationeryitems;



use App\Models\SchoolschoolsModel;
use App\Models\User;


class AdminDeliveryController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->username;
        $district_id = User::where('username', $user)->value('District_id');
        $quotesData = doc_quote::all();
        $deliveryData = deliveryCapture::all();
        

        $isActive = "1";



        $data = DB::table('deliveryselection')
            ->join('schools', 'deliveryselection.Emis', '=', 'schools.emis')
            ->select('schools.name', 'schools.emis', 'deliveryselection.RequestType', 'deliveryselection.References_Number')
            ->groupBy('schools.name', 'schools.emis', 'deliveryselection.RequestType', 'deliveryselection.References_Number')
            ->paginate(10);

        

        $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', session('Newemis'))->get();
        $dataSavedTextbookAdmin = $querySavedItems;
        session(['dataSavedTextbookAdmin' => $dataSavedTextbookAdmin]);
        
        //$OrderAmount = doc_quote::where('Emis', session('Newemis'))->value('ordered_amt');


        return view('furniture.AdminDelivery.list', compact('data', 'quotesData', 'deliveryData'));
    }

    public function CaptureData(Request $request, $delID, $requestType, $idInbox, $new_emis)
    {



        $idInbox = "1";

        $existDeliveredItem = deliveryCapture::where('SeqNo', $delID)->exists();

        session(['RequestTypes' => $requestType]);

       
        //Insert into the delivery_capture table
        if($existDeliveredItem)
        {
            DB::table('deliverycapture')
            ->where( 'SeqNo' , $delID)
            ->update([
                'RefNoSeq' => session("refNo")."_".$delID,      
            ]);
        }
        else 
        {
            DB::table('deliverycapture')
            ->insert([
                'RefNoSeq' => session("refNo")."_".$delID,
                'emis' => $new_emis,
                'SeqNo' => $delID,  
                'RequestType' =>  $requestType,
            ]);
        }
        $refSeqNo=  session("refNo")."_".$delID;
        session(['RefNoSeq' => $refSeqNo]);

        session(['DeliveredID' => $delID]);


        // Set session variables

        session()->forget('schoolLevel');
        /* if(session('status') != "complete")
        {
        session(['status' => "In Progress"]);
        } */
        //    $requestType = $request->input("RequestType");

        if ($requestType === "Textbook") {

            //  $emis = $request->input("emis");

            session(['NewrequestType' => $requestType]);
            session(['Newemis' => $new_emis]);
            $emis = session('Newemis');

            $textbookDataFromDatabase = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->where('refNoSeq' , $refSeqNo)->get();
            $allTextbookItemsSaved = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();

            // return view('your_blade_view', compact('textbookDataFromDatabase'));


            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);
            session(['allTextbookItemsSaved' => $allTextbookItemsSaved]);
            


            session()->forget('dataSavedTextbook');
            session()->forget('textbooksData');
            session()->forget('emis');
            session(['requestType' => $requestType]);
            session(['idInbox' => $idInbox]);


            $quoteStatus = inbox_school::where('Id', $idInbox)->value('status');
            session(['quoteStatus' => $quoteStatus]);

            //Set the default values of dropdown when page loads
            session(['selectedGrade' => 'default']);
            session(['selectedSubject' => 'default']);
            session(['selectedPublisher' => 'default']);


            $data = inbox_school::all();

            //Get all the SavedItems for textbook

            //Get Items list for the subject and Publisher dropdownList
            $ID = $request->input('IDVAl');

            $emis = $request->input("emis");
            session(['emis' => $emis]);
            $schoolLevel = School::where('emis', $emis)->value('level_id');


            $querySavedItems = savedtextbookitems::where('school_emis', $emis)->get();
            $dataSavedTextbook = $querySavedItems;
            session(['dataSavedTextbook' => $dataSavedTextbook]);

            session(['status' => 'In Progress']);



            $dataQuery  = DB::table('savedtextbookitems')
                ->join('textbookcat', 'savedtextbookitems.ISBN', '=', 'textbookcat.ISBN')
                ->select('textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.id', 'textbookcat.Subject', 'textbookcat.Publisher', 'textbookcat.Title', 'textbookcat.Price', 'savedtextbookitems.Quantity')
                ->where('savedtextbookitems.school_emis', session('Newemis'))
                ->paginate(10);


            $textbooksData = $dataQuery;
            session(['textbooksData' => $textbooksData]);


            session(['schoolLevel' => $schoolLevel]);
            $Subjects = textbookCatModel::distinct()->pluck('Subject');
            $Publishers = textbookCatModel::distinct()->pluck('Publisher');
            $status = "In Progress";



            $OrderAmount = doc_quote::where('Emis', session('Newemis'))->value('ordered_amt');

            $dataNew = DB::table('deliveryselection')
                ->where('Emis', $emis)
                ->where('RequestType', "Textbook")

                // Replace 'your_emis_value' with the actual value
                ->paginate(10);

            session()->forget('dataNew');
            session(['dataNew' => $dataNew]);


            $querySavedItems = savedtextbookitems::where('school_emis', $emis)->get();
            $dataSavedTextbook = $querySavedItems;
            session(['dataSavedTextbook' => $dataSavedTextbook]);

            return view('furniture.AdminDelivery.capture')
                ->with('data', $data)
                ->with('dataNew', $dataNew)
                ->with('requestType', $requestType)
                ->with('idInbox', $idInbox)
                ->with('emis', $emis)
                ->with('schoolLevel', $schoolLevel)
                ->with('Subjects', $Subjects)
                ->with('Publishers', $Publishers)
                ->with('Publishers', $Publishers)
                ->with('dataSavedTextbook', $dataSavedTextbook)
                ->with('textbooksData', $textbooksData)
                ->with('OrderAmount', $OrderAmount)
                ->with('textbookDataFromDatabase', $textbookDataFromDatabase);
        } else if ($requestType === "Stationery") {

            // $emis = $request->input("emis");

            $searchWord = "";

            session(['NewrequestType' => $requestType]);

            session(['Newemis' => $new_emis]);

            //stationeryData change to StationeryDataFromDatabase

            $emis = session('Newemis');

            // $StationeryDataFromDatabase = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
            // session(['StationeryDataFromDatabase' => $StationeryDataFromDatabase]);

            //   session(['requestType' => $requestType]);
            session(['idInbox' => $idInbox]);

            //    $stationeryData= stationeryCatModel::paginate(40);
            //  session(['stationeryData' => $stationeryData]); 

            //Saved Stationery Data
            $querySavedItems = savedstationeryitems::where('school_emis', $emis)->paginate(10);
            $stationeryCat = $querySavedItems;
            session(['stationeryCat' => $stationeryCat]);

            $querySavedItems = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
            $dataSavedStationery = $querySavedItems;
            session(['dataSavedStationery' => $dataSavedStationery]);

            $searchWord = "";

            $dataNewStat = DB::table('deliveryselection')
                ->where('Emis', session('Newemis'))
                ->where('RequestType', "Stationery")

                // Replace 'your_emis_value' with the actual value
                ->paginate(10);

            session(['dataNewStat' => $dataNewStat]);

            $quoteStatus = inbox_school::where('Id', $idInbox)->value('status');
            session(['quoteStatus' => $quoteStatus]);

            $AllocatedAmt = inbox_school::where('school_emis', $emis)->where('requestType', 'Stationery')->value('allocation');
            session(['AllocatedAmt' => $AllocatedAmt]);

            return view('furniture.AdminDelivery.StatCapture')
                ->with('requestType', $requestType)
                ->with('emis', $emis)
                ->with('idInbox', $idInbox)
                ->with('searchWord', $searchWord)
                ->with('dataSavedStationery', $dataSavedStationery)
                ->with('stationeryCat', $stationeryCat)


                ->with('dataNewStat', $dataNewStat);
        }
    }


    

    public function CaptureDataDelivery(Request $request,$refNo, $requestType, $idInbox, $new_emis)
    {

        $idInbox = "1";

        // Set session variables

        session()->forget('schoolLevel');
        session(['refNo' => $refNo]);
        /* if(session('status') != "complete")
        {
        session(['status' => "In Progress"]);
        } */
        //    $requestType = $request->input("RequestType");

        if ($requestType === "Textbook") {

            //  $emis = $request->input("emis");


            session(['NewrequestType' => $requestType]);

            session(['Newemis' => $new_emis]);


            $emis = session('Newemis');

            $textbookDataFromDatabase = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();

            // return view('your_blade_view', compact('textbookDataFromDatabase'));


            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);


            session()->forget('dataSavedTextbook');
            session()->forget('textbooksData');
            session()->forget('emis');
            session(['requestType' => $requestType]);
            session(['idInbox' => $idInbox]);


            $quoteStatus = inbox_school::where('Id', $idInbox)->value('status');
            session(['quoteStatus' => $quoteStatus]);

            //Set the default values of dropdown when page loads
            session(['selectedGrade' => 'default']);
            session(['selectedSubject' => 'default']);
            session(['selectedPublisher' => 'default']);


            $data = inbox_school::all();

            //Get all the SavedItems for textbook

            //Get Items list for the subject and Publisher dropdownList
            $ID = $request->input('IDVAl');

            $emis = $request->input("emis");
            session(['emis' => $emis]);
            $schoolLevel = School::where('emis', $emis)->value('level_id');


            $querySavedItems = savedtextbookitems::where('school_emis', $emis)->get();
            $dataSavedTextbook = $querySavedItems;
            session(['dataSavedTextbook' => $dataSavedTextbook]);

            session(['status' => 'In Progress']);



            $dataQuery  = DB::table('savedtextbookitems')
                ->join('textbookcat', 'savedtextbookitems.ISBN', '=', 'textbookcat.ISBN')
                ->select('textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.id', 'textbookcat.Subject', 'textbookcat.Publisher', 'textbookcat.Title', 'textbookcat.Price', 'savedtextbookitems.Quantity')
                ->where('savedtextbookitems.school_emis', session('Newemis'))
                ->paginate(10);


            $textbooksData = $dataQuery;
            session(['textbooksData' => $textbooksData]);


            session(['schoolLevel' => $schoolLevel]);
            $Subjects = textbookCatModel::distinct()->pluck('Subject');
            $Publishers = textbookCatModel::distinct()->pluck('Publisher');
            $status = "In Progress";



            $dataNew = DB::table('deliveryselection')
                ->where('Emis', $emis)
                ->where('RequestType', "Textbook")
                ->where('IsActive' , "1")

                // Replace 'your_emis_value' with the actual value
                ->paginate(10);

            session()->forget('dataNew');
            session(['dataNew' => $dataNew]);


            $querySavedItems = savedtextbookitems::where('school_emis', $emis)->get();
            $dataSavedTextbook = $querySavedItems;
            session(['dataSavedTextbook' => $dataSavedTextbook]);

            return view('furniture.AdminDelivery.DeliveryCap')
                ->with('data', $data)
                ->with('dataNew', $dataNew)
                ->with('requestType', $requestType)
                ->with('idInbox', $idInbox)
                ->with('emis', $emis)
                ->with('schoolLevel', $schoolLevel)
                ->with('Subjects', $Subjects)
                ->with('Publishers', $Publishers)
                ->with('Publishers', $Publishers)
                ->with('dataSavedTextbook', $dataSavedTextbook)
                ->with('textbooksData', $textbooksData)
                ->with('textbookDataFromDatabase', $textbookDataFromDatabase);
        } else if ($requestType === "Stationery") {

            // $emis = $request->input("emis");

            $searchWord = "";

            session(['NewrequestType' => $requestType]);

            session(['Newemis' => $new_emis]);

            //stationeryData change to StationeryDataFromDatabase

            $emis = session('Newemis');

            // $StationeryDataFromDatabase = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
            // session(['StationeryDataFromDatabase' => $StationeryDataFromDatabase]);

            //   session(['requestType' => $requestType]);
            session(['idInbox' => $idInbox]);

            //    $stationeryData= stationeryCatModel::paginate(40);
            //  session(['stationeryData' => $stationeryData]); 

            //Saved Stationery Data
            $querySavedItems = savedstationeryitems::where('school_emis', $emis)->paginate(10);
            $stationeryCat = $querySavedItems;
            session(['stationeryCat' => $stationeryCat]);

            $querySavedItems = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
            $dataSavedStationery = $querySavedItems;
            session(['dataSavedStationery' => $dataSavedStationery]);

            $searchWord = "";

            $dataNewStat = DB::table('deliveryselection')
                ->where('Emis', session('Newemis'))
                ->where('RequestType', "Stationery")

                // Replace 'your_emis_value' with the actual value
                ->paginate(10);

            session(['dataNewStat' => $dataNewStat]);

            $quoteStatus = inbox_school::where('Id', $idInbox)->value('status');
            session(['quoteStatus' => $quoteStatus]);

            $AllocatedAmt = inbox_school::where('school_emis', $emis)->where('requestType', 'Stationery')->value('allocation');
            session(['AllocatedAmt' => $AllocatedAmt]);

            return view('furniture.AdminDelivery.StatCapture')
                ->with('requestType', $requestType)
                ->with('emis', $emis)
                ->with('idInbox', $idInbox)
                ->with('searchWord', $searchWord)
                ->with('dataSavedStationery', $dataSavedStationery)
                ->with('stationeryCat', $stationeryCat)


                ->with('dataNewStat', $dataNewStat);
        }
    }


    public function filterTextbookAdmin(Request $request)
    {

        $dataNew = DB::table('deliveryselection')
            ->where('Emis', session('Newemis')) // Replace 'your_emis_value' with the actual value
            ->paginate(10);

        //***************************************Ella Start***************************************************** */
        $data = inbox_school::all();
        $messageLoaded = "";

        $emis = session('Newemis');


        $dataSavedTextbook =  session('dataSavedTextbook');
        $requestType = session('requestType', 'default_value_if_not_set');
        $schoolLevel = session('schoolLevel', 'default_value_if_not_set');
        $idInbox = session('idInbox', 'default_value_if_not_set');

        // Set dropdown filters
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

        if ($subjectSelected == "default" && $publisherSelected == "default" && $gradeSelected == "default") {
            $avoidFilter = true;
        } elseif ($subjectSelected == "default" && $publisherSelected == "default") {
            $query = DB::table('savedtextbookitems')
                ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->where('textbookcat.Grade', $gradeSelected);



            // $variable = 'some value 6';
            // dump($variable);


        } elseif ($gradeSelected == "default" && $publisherSelected == "default") {
            $query = DB::table('savedtextbookitems')
                ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->where('textbookcat.Subject', $subjectSelected);


            // $variable = 'some value 7';
            // dump($variable);


        } elseif ($gradeSelected == "default" && $subjectSelected == "default") {
            $query = DB::table('savedtextbookitems')
                ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->where('textbookcat.Publisher',  $publisherSelected);

            // $variable = 'some value 8';
            // dump($variable);

        } elseif ($subjectSelected == "default") {
            $query = DB::table('savedtextbookitems')
                ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->where('textbookcat.Publisher',  $publisherSelected)
                ->where('textbookcat.Grade',  $gradeSelected);

            // $variable = 'some value 9';
            // dump($variable);


        } elseif ($publisherSelected == "default") {
            $query = DB::table('savedtextbookitems')
                ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->where('textbookcat.Subject',   $subjectSelected)
                ->where('textbookcat.Grade',  $gradeSelected);

            // $variable = 'some value 10';
            // dump($variable);

        } elseif ($gradeSelected == "default") {
            $query = DB::table('savedtextbookitems')
                ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->where('textbookcat.Subject',   $subjectSelected)
                ->where('textbookcat.Publisher',  $publisherSelected);

            // $variable = 'some value 11';
            // dump($variable);

        } else {
            $query = DB::table('savedtextbookitems')
                ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->where('textbookcat.Publisher',   $publisherSelected)
                ->where('textbookcat.Grade',  $gradeSelected);

            // $variable = 'some value 12';
            // dump($variable);
        }

        $queryParams = [
            'Subject' => $subjectSelected,
            'Publisher' => $publisherSelected,
            'Grade' => $gradeSelected,
        ];

        if ($avoidFilter) {
            /* if ($schoolLevel == 1) {
                    $queryCatalogueData = textbookCatModel::whereBetween('Grade', [1, 7]);
            
                    $dataQuery = DB::table('savedtextbookitems')
                    ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                    ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                    ->whereIn('textbookcat.Grade', $queryCatalogueData->pluck('Grade')->toArray())
                    ->paginate(10);

                    // $variable = 'some value 1';
                    // dump($variable);


                } elseif ($schoolLevel == 2) {
                    $queryCatalogueData = textbookCatModel::whereBetween('Grade', [8, 12]);
            
                    $dataQuery = DB::table('savedtextbookitems')
                    ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                    ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                ->whereIn('textbookcat.Grade', $queryCatalogueData->pluck('Grade')->toArray())
                    ->paginate(10);

                    // $variable = 'some value 2';
                    // dump($variable);

                } else {
                    $queryCatalogueData = textbookCatModel::whereBetween('Grade', [1, 12]);
            
                $dataQuery = DB::table('savedtextbookitems')
                    ->join('textbookcat', 'textbookcat.ISBN', '=', 'savedtextbookitems.ISBN')
                    ->select('textbookcat.*', 'textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.Subject', 'textbookcat.Subject', 'textbookcat.Publisher', 'savedtextbookitems.Price', 'savedtextbookitems.Quantity')
                        ->whereIn('textbookcat.Grade', $queryCatalogueData->pluck('Grade')->toArray())
                    ->paginate(10);

                    // $variable = 'some value 3';
                    // dump($variable);
                } */

            $dataQuery  = DB::table('savedtextbookitems')
                ->join('textbookcat', 'savedtextbookitems.ISBN', '=', 'textbookcat.ISBN')
                ->select('textbookcat.ISBN', 'textbookcat.Grade', 'textbookcat.id', 'textbookcat.Subject', 'textbookcat.Publisher', 'textbookcat.Title', 'textbookcat.Price', 'savedtextbookitems.Quantity')
                ->where('savedtextbookitems.school_emis', session('Newemis'))
                ->paginate(10);

            $textbooksData = $dataQuery;
            session(['textbooksData' => $textbooksData]);

            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
            $textbookDataFromDatabase = $querySavedItems;
            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);
        } else {

            // $variable = 'some value 4';
            // dump($variable);

            // session()->forget('textbooksData');
            $textbooksData = session('textbooksData');

            $textbooksData = $query->paginate(10)->withQueryString();
            session(['textbooksData' => $textbooksData]);

            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
            $textbookDataFromDatabase = $querySavedItems;
            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);
        }
        //     $variable = 'some value 5';
        // dump($variable);




        $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
        $textbookDataFromDatabase = $querySavedItems;
        session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);

        return view('furniture.AdminDelivery.capture', compact('data', 'dataNew', 'textbooksData', 'requestType', 'Subjects', 'Publishers', 'idInbox', 'messageLoaded', 'dataSavedTextbook', 'schoolLevel', 'emis'));
    }




    public function saveCheckedItemsForTextbook(Request $request)
    {
        $emis = session('Newemis');
        $RequestType = session('NewrequestType');

        $newItems = $request->input('selectedItems');

        $Final = $request->input('inlineRadioOptions');

        //if not empty
        $ReferenceNo = session("RefNoSeq");

        $TPCapQuantity = $request->input('TPCapQuantity');

        $ExistingCapturedQuantity = deliveryCapture::where('RefNoSeq', $ReferenceNo)->value('TotalCaptureQuantityAmount');




        if($Final != null){

            DB::table('deliverycapture')
            ->where('RefNoSeq' , $ReferenceNo)
            ->update([
                'isFinal' => "Yes",

            ]);
        }
        $totalT=0;

        //Delete items that are unchecked
        $uncheckedItems = explode(',', $request->input('UncheckedItems'));
        foreach ($uncheckedItems as $itemId) {
            AdminSavedTextbookCapturedValueModel::where('textbook_id', $itemId)->delete();
        }

        if ($newItems != null) {
            $selectedQuantities = $request->input('selectedQuantities');
            $EnteredQuantities = $request->input('CapturedQuantity');



            try {
                foreach ($newItems as $itemId) {
                    $item = textbookCatModel::find($itemId);

                    if ($item) {
                        $price = (float) str_replace(['R', ',', ' '], '', $item->Price);
                        $quantity = $selectedQuantities[$itemId];

                        $quantity1 = $EnteredQuantities[$itemId];
                        //dump($quantity1);

                        $emis = session('Newemis');
                        $existingItem = AdminSavedTextbookCapturedValueModel::where('refNoSeq', session("RefNoSeq"))->where('textbook_id', $itemId)
                            ->where('Emis', $emis)
                            ->first();

                            $totalT =  $totalT + ($quantity1 * $price);
                           // dump($totalT);

                            $TotalAll = $ExistingCapturedQuantity + $totalT ;
                          
                            $deliveryID = session('DeliveredID');

                        if ($existingItem) {

                            //   dump($item->id);

                            DB::table('adminsavedtextbookcapturedvalue')
                                ->where('refNoSeq', session("RefNoSeq"))
                                ->update([
                                    'Captured_Quantity' => $quantity1,
                                ]);

                                DB::table('deliveryselection')
                                ->where('Id' , $deliveryID)
                                ->update([
                                    'IsActive' => '0',
                        
                                ]);
    
                            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
                            $textbookDataFromDatabase = $querySavedItems;
                            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);
                        } else {
                            AdminSavedTextbookCapturedValueModel::create([
                                'Emis' => $emis,
                                'Title' => $item->Title,
                                'Publisher' => $item->Publisher,
                                'Subject' => $item->Subject,
                                'ISBN' => $item->ISBN,
                                'Grade' => $item->Grade,
                                'Price' => $price,
                                'Quantity' => $quantity,
                                'Captured_Quantity' => $quantity1,
                                'RequestType' => $RequestType,
                                'textbook_id' => $item->id,
                                'activeTab' => 'tab1',
                                'refNoSeq' => session("RefNoSeq")

                            ]);

                            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
                            $textbookDataFromDatabase = $querySavedItems;
                            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);

                            
                            DB::table('deliveryselection')
                            ->where('Id' , $deliveryID)
                            ->update([
                                'IsActive' => '0',
                    
                            ]);

                        }
                    }
                }


                DB::table('deliverycapture')
                ->where('RefNoSeq', $ReferenceNo)
                ->update([
                    'TotalCaptureQuantityAmount' => $totalT + $ExistingCapturedQuantity,
                ]);

                
            } catch (\Exception $e) {
                // Handle exceptions if needed
                dump("Error: " . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while processing the data.');
            }
        }




        $isNextClicked = $request->input('nextPage') === 'true';

        // Check if the "Previous" button was clicked
        $isPreviousClicked = $request->input('previousPage') === 'true';

        // Now, you can perform logic based on these flags
        if ($isNextClicked) {

            $currentPage = session('textbooksData')->currentPage(); // Get the current page number
            $nextPage = $currentPage + 1;

            $nextPageUrl = route('filterTextbookAdmin', [
                'page' =>   $nextPage, // Assuming $textbooksData is a paginator
                'Subject' => session('selectedSubject'),
                'Publisher' => session('selectedPublisher'),
                'Grade' => session('selectedGrade'),
                'activeTab' => 'tab1',
            ]);
            // session()->forget('selectedItems');
            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
            $textbookDataFromDatabase = $querySavedItems;
            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);




            return redirect($nextPageUrl);
        } elseif ($isPreviousClicked) {

            $currentPage = session('textbooksData')->currentPage(); // Get the current page number
            $previousPage = $currentPage - 1;

            $previousPageUrl = route('filterTextbookAdmin', [
                'page' =>   $previousPage, // Assuming $textbooksData is a paginator
                'Subject' => session('selectedSubject'),
                'Publisher' => session('selectedPublisher'),
                'Grade' => session('selectedGrade'),
                'activeTab' => 'tab1',
            ]);
            //    session()->forget('selectedItems');

            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
            $textbookDataFromDatabase = $querySavedItems;
            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);

            return redirect($previousPageUrl);
        }

        //return redirect()->route('textbookCat', ['requestType' => "Textbook", 'idInbox' => $idInbox]);


        //return redirect()->back()->with('success', 'Data Successfully Captured/Updated.');


        $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
        $textbookDataFromDatabase = $querySavedItems;
        session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);

        return redirect()->back()->with('success', 'Data Successfully Captured/Updated.');
    }


    public function deleteTextbookItem($id)
    {

        // Delete the record with the specified ISBN
        $emis = session('Newemis');

        $result = AdminSavedTextbookCapturedValueModel::where('Id', $id)->delete();
        $textbookDataFromDatabase = $result;

        $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
        $textbookDataFromDatabase = $querySavedItems;
        session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);




        if ($result) {
            return redirect()->back()->with([
                'success' => 'Item Deleted Successfullysss!',
                'activeTab' => 'tab3',
                'textbookDataFromDatabase' =>  $textbookDataFromDatabase,



            ]);


            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
            $textbookDataFromDatabase = $querySavedItems;
            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);
        } else {
            return redirect()->back()->with([
                'success' => 'Item Deleted SuccessfullyGG!',
                'activeTab' => 'tab3',
                'textbookDataFromDatabase' =>  $textbookDataFromDatabase,

                // Set the active tab here
            ]);



            $querySavedItems = AdminSavedTextbookCapturedValueModel::where('Emis', $emis)->get();
            $textbookDataFromDatabase = $querySavedItems;
            session(['textbookDataFromDatabase' => $textbookDataFromDatabase]);
        }
    }





    /*********************************Below are Stationary Methood******************************* */


    public function searchStationeryAdmin(Request $request)
    {
        //$requestType = session('requestType', 'default_value_if_not_set');
        //$idInbox = session('idInbox', 'default_value_if_not_set');

        $requestType = session('NewrequestType');

        $searchWord = $request->input('searchKeyword');
        session(['searchWord' => $searchWord]);

        if ($searchWord != null) {
            $queryCatalogueData = savedstationeryitems::where('item_title', 'like', '%' . $searchWord . '%');
            $stationeryData = $queryCatalogueData->paginate(40);
        } else {
            $stationeryData = savedstationeryitems::paginate(40);
        }


        session()->forget('stationeryCat');
        session(['stationeryCat' => $stationeryData]);


        //stationeryData change to StationeryDataFromDatabase

        $emis = session('Newemis');

        //Saved Stationery Data
        $querySavedItems = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
        $dataSavedStationery = $querySavedItems;
        session(['dataSavedStationery' => $dataSavedStationery]);


        $dataNewStat = DB::table('deliveryselection')
            ->where('Emis', session('Newemis'))
            ->where('RequestType', "Stationery")

            // Replace 'your_emis_value' with the actual value
            ->paginate(10);

        session(['dataNewStat' => $dataNewStat]);

        return view('furniture.AdminDelivery.StatCapture')
            ->with('requestType', $requestType)
            ->with('emis', $emis)
            ->with('idInbox', "1")
            ->with('searchWord', $searchWord)
            ->with('dataSavedStationery', $dataSavedStationery)
            ->with('stationeryCat', $stationeryData);
    }

    public function saveCheckedItemsStat(Request $request)
    {

        //  session()->forget('selectedItems');
        $idInbox = session('idInbox', 'default_value_if_not_set');

        //stationeryData change to StationeryDataFromDatabase

        $emis = session('Newemis');
        // Retrieve the new array from the request


        //Delete items that are unchecked
        $uncheckedItems = explode(',', $request->input('UncheckedItems'));
        foreach ($uncheckedItems as $itemId) {
            AdminSavedStationeryCapturedValueModel::where('stationery_id', $itemId)->delete();
        }


        if (session('quoteStatus') != "Quote Created") {
            $newItems = $request->input('selectedItems');

            $querySavedItems = savedstationeryitems::where('school_emis', $emis)->paginate(10);
            $stationeryCat = $querySavedItems;
            session(['stationeryCat' => $stationeryCat]);

            //Delete items that are unchecked
            $uncheckedItems = explode(',', $request->input('UncheckedItems'));
            foreach ($uncheckedItems as $itemId) {
                AdminSavedStationeryCapturedValueModel::where('stationery_id', $itemId)->delete();
            }


            //Check if there is any null items from the newly selected items
            if ($newItems != null) {


                // dump($newItems);

                // Validation logic

                $selectedQuantities = $request->input('selectedQuantities');

                $CapturedQuantity = $request->input('CaptureQuantity');


                $variable = 'some value 6';

                //INSERT INTO `savedstationeryitems`(`id`, `item_code`, `item_title`, `price`, `Quantity`, `TotalPrice`, `inbox_id`, `stationery_id`, `school_emis`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')
                $selectedRecords = savedstationeryitems::whereIn('id', $newItems)->get(['id', 'item_code', 'item_title', 'price']);

                // dump($selectedRecords);

                $querySavedItems = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
                $dataSavedStationery = $querySavedItems;
                session(['dataSavedStationery' => $dataSavedStationery]);


                try {

                    foreach ($selectedRecords as $record) {

                        // dump($record);

                        //INSERT INTO `adminsavedstationerycapturedvalue`(`id`, `ItemCode`, `Emis`, `Item`, `Quantity`, `UnitPrices`, `Captured_Quantity`, `updated_at`, `created_at`, `stationery_id`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
                        $SavedItem = AdminSavedStationeryCapturedValueModel::where('ItemCode', $record->item_code)->first();
                        $itemId = $record->id;
                        $price = (float) str_replace(['R', ',', ' '], '', 100.00);
                        $quantity = $selectedQuantities[$itemId];
                        $Capturedquantity = $CapturedQuantity[$itemId];

                        //Check if the item exist, if it does then do an update 
                        //INSERT INTO `adminsavedstationerycapturedvalue`(`id`, `ItemCode`, `Emis`, `Item`, `Quantity`, `UnitPrices`, `Captured_Quantity`, `updated_at`, `created_at`, `stationery_id`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
                        if ($SavedItem) {

                            DB::table('adminsavedstationerycapturedvalue')
                                ->where('ItemCode', $record->item_code)
                                ->update([
                                    'Captured_Quantity' => $quantity,

                                ]);
                        } // else the item will be inserted as new record
                        else {

                            //  dump("Here to insert");
                            // INSERT INTO `adminsavedstationerycapturedvalue`(`id`, `ItemCode`, `Emis`, `Item`, `Quantity`, `UnitPrices`, `Captured_Quantity`, `updated_at`, `created_at`, `stationery_id`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')

                            // INSERT INTO `stationarycat`(`id`, `ItemCode`, `Item`, `Quantity`, `UnitPrices`, `updated_at`, `created_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
                            $itemId = $record->id;
                            //INSERT INTO `savedstationeryitems`(`id`, `item_code`, `item_title`, `price`, `Quantity`, `TotalPrice`, `inbox_id`, `stationery_id`, `school_emis`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')
                            DB::table('adminsavedstationerycapturedvalue')
                                ->insert([
                                    'ItemCode' => $record->item_code,
                                    'Item' => $record->item_title,
                                    'UnitPrices' => $record->price,
                                    'Quantity' => $quantity,
                                    'Captured_Quantity' => $Capturedquantity,
                                    'stationery_id' => $record->id,
                                    'Emis' => $emis,
                                ]);
                        }
                    }
                } catch (\Exception $e) {
                }
            }

            session()->forget('dataSavedStationery');
            $querySavedItems = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
            $dataSavedTextbook = $querySavedItems;
            session(['dataSavedStationery' => $dataSavedTextbook]);


            $isNextClicked = $request->input('nextPage') === 'true';

            // Check if the "Previous" button was clicked
            $isPreviousClicked = $request->input('previousPage') === 'true';

            // Now, you can perform logic based on these flags
            if ($isNextClicked) {

                $currentPage = session('stationeryCat')->currentPage(); // Get the current page number
                $nextPage = $currentPage + 1;

                $nextPageUrl = route('CaptureData', [
                    'page' =>   $nextPage, // Assuming $textbooksData is a paginator
                    //  'searchWord' => session('searchWord'),
                    'requestType' => "Stationery",
                    'idInbox' => "1",
                    'emis_new' => session('Newemis')
                ]);
                session()->forget('selectedItems');

                $dataNewStat = DB::table('deliveryselection')
                    ->where('Emis', session('Newemis'))
                    ->where('RequestType', "Stationery")

                    // Replace 'your_emis_value' with the actual value
                    ->paginate(10);

                session(['dataNewStat' => $dataNewStat]);

                return redirect($nextPageUrl);
            } elseif ($isPreviousClicked) {

                $currentPage = session('stationeryCat')->currentPage(); // Get the current page number
                $previousPage = $currentPage - 1;

                $previousPageUrl = route('CaptureData', [
                    'page' =>   $previousPage, // Assuming $textbooksData is a paginator
                    //  'searchWord' => session('searchWord'),
                    'requestType' => "Stationery",
                    'idInbox' => "1",
                    'emis_new' => session('Newemis')

                ]);

                $dataNewStat = DB::table('deliveryselection')
                    ->where('Emis', session('Newemis'))
                    ->where('RequestType', "Stationery")

                    // Replace 'your_emis_value' with the actual value
                    ->paginate(10);

                session(['dataNewStat' => $dataNewStat]);
                session()->forget('selectedItems');
                return redirect($previousPageUrl);
            }

            return redirect()->back();
        }
    }


    //Delete saved stationery item
    public function deleteStationeryItem($id)
    {

        // Delete the record with the specified ISBN
        $emis = session('Newemis');
        $result = AdminSavedStationeryCapturedValueModel::where('id', $id)->delete();

        //   $querySavedItems= savedstationeryitems::where('school_emis', $emis)->get();
        //   $dataSavedTextbook=$querySavedItems;
        //   session(['dataSavedStationery' => $dataSavedTextbook]);


        $querySavedItems = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
        $dataSavedStationery = $querySavedItems;
        session(['dataSavedStationery' => $dataSavedStationery]);


        if ($result) {
            return redirect()->back()->with([
                'success' => 'Item Deleted Successfully!',
                'activeTab' => 'tab3', // Set the active tab here
            ]);
        } else {
            return redirect()->back()->with([
                'success' => 'Item Deleted SuccessfullyNO!',
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







    public function CaptureStat($requestType, $idInbox)
    {



        $emis = session('Newemis');

        $dataNewStat = DB::table('deliveryselection')
            ->where('Emis', session('Newemis'))
            ->where('RequestType', "Stationery")

            // Replace 'your_emis_value' with the actual value
            ->paginate(10);

        session(['dataNewStat' => $dataNewStat]);



        session(['requestType' => $requestType]);
        session(['idInbox' => $idInbox]);


        $stationeryData = stationeryCatModel::paginate(40);
        session(['stationeryData' => $stationeryData]);

        //Saved Stationery Data
        $querySavedItems = savedstationeryitems::where('school_emis', $emis)->get();
        $dataSavedStationery = $querySavedItems;
        session(['dataSavedStationery' => $dataSavedStationery]);

        $searchWord = "";


        $quoteStatus = inbox_school::where('Id', $idInbox)->value('status');
        session(['quoteStatus' => $quoteStatus]);

        $AllocatedAmt = inbox_school::where('school_emis', $emis)->where('requestType', 'Stationery')->value('allocation');
        session(['AllocatedAmt' => $AllocatedAmt]);


        return view('furniture.AdminDelivery.StatCapture')
            ->with('requestType', $requestType)
            ->with('emis', $emis)
            ->with('idInbox', $idInbox)
            ->with('searchWord', $searchWord)
            ->with('dataSavedStationery', $dataSavedStationery)
            ->with('stationeryData', $stationeryData);
    }




    public function searchRequest(Request $request)
    {
        $quotesData = doc_quote::all();
        $deliveryData = deliveryCapture::all();


        $messages ="";
        $query = DB::table('deliveryselection')
            ->join('schools', 'deliveryselection.Emis', '=', 'schools.emis')
            ->select('schools.name', 'schools.emis', 'deliveryselection.RequestType', 'deliveryselection.References_Number')
            ->groupBy('schools.name', 'schools.emis', 'deliveryselection.RequestType', 'deliveryselection.References_Number');
    
        // Apply search conditions based on the form input
        if ($request->filled('ref_number')) {
            $query->where('deliveryselection.References_Number', 'LIKE', '%' . $request->input('ref_number') . '%');
        }
    
        if ($request->filled('school_name')) {
            $query->where('schools.name', 'LIKE', '%' . $request->input('school_name') . '%');
        }
    
        // if ($request->filled('status_id')) {
        //     $query->where('your_status_column', $request->input('status_id')); // Replace 'your_status_column' with the actual column name
        // }

        // $status =$request->input('status_id');
        // if($status  === "Complete"){
        //     $query->where('isFinal' , "Yes");
        // }else if($status  === "Pending"){
        //     $query->where('isFinal' , null);
        // }
    
        if ($request->filled('RequestType')) {
            $query->where('deliveryselection.RequestType', $request->input('RequestType'));
        }
    
        if ($request->filled('emis')) {
            $query->where('schools.emis', 'LIKE', '%' . $request->input('emis') . '%');
        }

         
    
        $data = $query->paginate(10);

           // Check if any records were found
    if ($data->isEmpty()) {
        $messages = 'No records found.';
    }

    
        // Return the view with the filtered data
        return view('furniture.AdminDelivery.list', compact('data', 'messages', 'quotesData', 'deliveryData'));

        //return view('furniture.AdminDelivery.list', compact('data', 'quotesData', 'deliveryData'));

    }
    
}
