
<?php
         //   dump("HJHhhh");
            // $emis = $request->input("emis");

            $searchWord = "";

            session(['NewrequestType' => $requestType]);

            session(['Newemis' => $new_emis]);

            //stationeryData change to StationeryDataFromDatabase

            $emis = session('Newemis');

             $StationeryDataFromDatabase = AdminSavedStationeryCapturedValueModel::where('Emis', $emis)->get();
            session(['StationeryDataFromDatabase' => $StationeryDataFromDatabase]);

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