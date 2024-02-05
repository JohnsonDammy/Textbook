<?php

namespace App\Providers;

use App\Models\inbox_school;
use App\Models\Inbox;
use Illuminate\Support\ServiceProvider;
use App\Models\UploadModel;
use App\Models\RequestFundsModel;
use App\Models\RequestPrecurementModel;
use App\Models\User;
use App\Models\doc_quote;
use App\Models\deliveryCapture;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;


class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.layout', function ($view) {
            $emis = optional(Auth::user())->username;
    
            if ($emis === null) {
                return view('http://127.0.0.1:8000/home');
                
            }
            $existAllocation = UploadModel::where('EMIS', $emis)->exists();
            $existSelection = inbox_school::where('School_Emis', $emis)->exists();
            $hideDelivery= RequestFundsModel::where('School_Emis', $emis)->value("Status");
            $HideForNoDeclaration = RequestPrecurementModel::where('School_Emis', $emis)->where('NoDeclaration', "Yes")->exists();

            $districtId = Auth::user()->District_Id;


            $notificationInbox = Inbox::where('District_Id', $districtId)->where('DelVal' , "1")
            
            ->count();


            $countPending = deliveryCapture::where('isFinal',null) ->count();

            $countinbox = inbox_school::where('school_emis', $emis)->where('status', "",) ->where('activity_name', "Create Quote")->count();
                             


            $user = Auth::user()->username;
            $district_id = User::where('username', $user)->value('District_id');
            $quotesData = doc_quote::all();
            $deliveryData = deliveryCapture::all();
             
            $countNonNullChecklistNames = inbox_school::where('district_id', $district_id)
                    ->where('status', 'Quote Received')
                    ->where('checkListName',null)->count();
                        
                                                    
    
            $isActive = "1";
    
    
    
            $query = DB::table('deliveryselection')
            ->join('schools', 'deliveryselection.Emis', '=', 'schools.emis')
            ->select('schools.name', 'schools.emis', 'deliveryselection.RequestType', 'deliveryselection.References_Number')
            ->groupBy('schools.name', 'schools.emis', 'deliveryselection.RequestType', 'deliveryselection.References_Number');
        
        // Get the count of records
        $countDelivery = $query->count();
        
        // Use the paginate() method to get paginated results
        $data = $query->paginate(10);
        

            $AllowProcurement = $existAllocation ? true : false;
            $view->with('AllowProcurement', $AllowProcurement)
                 ->with('existSelection', $existSelection)
                 ->with('HideForNoDeclaration',   $HideForNoDeclaration)
                 ->with('hideDelivery', $hideDelivery)
                 ->with('notificationInbox', $notificationInbox)
                 ->with('countDelivery', $countDelivery)
                 ->with('countPending',  $countPending)
                 ->with('countNonNullChecklistNames',  $countNonNullChecklistNames)
                 ->with('countinbox',  $countinbox);


        });
    }
}
