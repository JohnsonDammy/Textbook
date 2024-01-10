<?php

namespace App\Providers;

use App\Models\inbox_school;
use Illuminate\Support\ServiceProvider;
use App\Models\UploadModel;
use App\Models\RequestFundsModel;
use App\Models\RequestPrecurementModel;
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

            $AllowProcurement = $existAllocation ? true : false;
            $view->with('AllowProcurement', $AllowProcurement)
                 ->with('existSelection', $existSelection)
                 ->with('HideForNoDeclaration',   $HideForNoDeclaration)
                 ->with('hideDelivery', $hideDelivery);
        });
    }
}
