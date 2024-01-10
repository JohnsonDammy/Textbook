<?php

namespace App\Http\Controllers;

use App\Models\inbox_school;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\RequestFundsModel;
use App\Models\savedtextbookitems;
use App\Models\savedstationeryitems;
use App\Models\RequestPrecurementModel;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use App\Models\School;

class History_Requests extends Controller
{
    
    
    public function index()
    {
        $emis =  Auth::user()->username;
        $data = RequestFundsModel::where('School_Emis', $emis)
        ->orderBy('year', 'desc')
        ->get();
        
        $yearnow = date('Y');
        $textbook_amount= RequestFundsModel::where('School_Emis', $emis)
        ->where('year', date('Y'))->value('amount_textbook');

      
        $circular_id=RequestPrecurementModel::where('School_Emis', $emis)->value('circular_id');
        $currentRequest=RequestFundsModel::where('School_Emis', $emis)
        ->where('year', date('Y'))->first();

        $stationery_amount=RequestFundsModel::where('School_Emis', $emis)
        ->where('year', date('Y'))->value('amount_stationery');

        return view('Section21_C.HistoryRequests.Funding_History_Request', compact('data', 'textbook_amount', 'stationery_amount', 'currentRequest', 'circular_id', 'yearnow'));
    }




    
    public function updateRequestCurrent(Request $request)
{
    try {
        $emis = Auth::user()->username;
        $data = RequestFundsModel::where('School_Emis', $emis)
            ->where('year', date('Y'))
            ->get();

        $currentRequest = RequestFundsModel::where('School_Emis', $emis)
            ->where('year', date('Y'))
            ->first();

        if ($currentRequest) {

            DB::table('fundsrequest')->update([
                    
                                
                'amount_textbook'=> $request->input('firstAmount'),
                'amount_stationery' => $request->input('secondAmount'),
        
        ]);

            
        }
        return redirect()->route('Request_History.index')->with([
            'success' => 'Successfully udated current request'
        ]);
    } catch (Exception $e) {
        \Log::error($e->getMessage());
        return redirect()->route('Request_History.index')->with('failed', 'Failed to update current request');
    }
}


    
    public function deleteRequestCurrent($id)
    {
        try {
           
            
            //Delete all relevant tables in which funds allocation is dependant on
            savedtextbookitems::where('school_emis', $id)->delete();
            savedstationeryitems::where('school_emis', $id)->delete();
            inbox_school::where('school_emis', $id)->delete();

            // Delete the main request allocation record
            RequestFundsModel::where('school_emis', $id)->delete();
       

            return redirect()->route('Request_History.index')->with([
                'success' => 'Successfully deleted current request'
            ]);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->route('Request_History.index')->with([
                'failed' => 'Failed to delete current request'
            ]);
        }
        

    

    }
}
