   <?php
   
   public function SaveUnitPriceStationery(Request $request)
    {

        //  session()->forget('selectedItems');
       // $idInbox = session('idInbox', 'default_value_if_not_set');
        $emis = session('Emis');
        $fundsId = session('fundsId');
        // Retrieve the new array from the request

        $selectedItems  = $request->input('selectedItems');

        $CheckVal  = $request->input('CheckVal');

        if($CheckVal === "true"){
            DB::table('inbox_school')
            ->where('school_emis', $emis)
            ->where('requestType', 'Stationery')
            ->update([
                'status' => "Allocated Funds",
                'activity_name' => "Create New Quote",
           ]);
           return redirect()->route('InboxSchoolDistrict');

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


       return redirect()->route('AdminCaptureStatUnitPrice', ['RequestTypes' => "Stationery", 'Emis' => $emis, 'fundsId' => $fundsId]);
        } catch (\Exception $e) {
        }


        $isNextClicked = $request->input('nextPage') === 'true';
        $isPreviousClicked = $request->input('previousPage') === 'true';

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

          //  session()->forget('selectedItems');
            return redirect($previousPageUrl);
        }
    }
