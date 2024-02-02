<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\stationeryCatModel;
use App\Models\StationeryCartSchool;
use App\Models\savedstationeryitems;
use Illuminate\Http\Request;

class SchoolStationery extends Controller
{
    //
    public function addItemToCart(Request $request)
    {
        // Check if the item already exists in the stationeryCatModel table
        $existingItemCatModel = stationeryCatModel::where('Item', $request->input('itemName'))->first();
        $existinsertIntoSaveStationeryItem = savedstationeryitems::where('item_title', $request->input('itemName'))->first();
        if ($existingItemCatModel) {
            // Check if the item already exists in the StationeryCartschool table
            $existingInSchool = StationeryCartSchool::where('Item', $existingItemCatModel->Item)->first();

            // if ($existingInSchool) {
            //     // Item is already in StationeryCartschool, display a message
            //     return redirect()->route('StationeryAddNew')->with('errorMessage1', 'Stationery already added');
            // }

            // Item is not in StationeryCartschool, insert a new record
           // $this->insertIntoStationeryCartSchool($existingItemCatModel);
            //
            return redirect()->route('StationeryAddNew')->with('errorMessage1', 'Stationery already added');

        } else {
        // Item is not in the cart, get the last item code from the StationeryCart table and increment it by 1
       
            // Insert into stationeryCatModel table
            $lastItemCode = stationeryCatModel::max('ItemCode');
            $newItemCode = $lastItemCode + 1;

            // Insert a new record into stationeryCatModel
            $newItem = new stationeryCatModel();
            $newItem->ItemCode = $newItemCode;
            $newItem->Item = $request->input('itemName');
            $newItem->quantity = 0;
            $newItem->UnitPrices = 0;
            $newItem->updated_at = now();
            $newItem->created_at = now();
            $newItem->save();

            // Insert into StationeryCartSchool table
            $this->insertIntoStationeryCartSchool($newItem);
            return redirect()->route('stationeryCat', ['requestType' => 'Stationery', 'idInbox' => 1])->with('success', 'Stationery Added Successfully');
        }


        
       
    }

    private function insertIntoStationeryCartSchool($item)
    {
        // Check if the item already exists in StationeryCartschool before inserting
        $existingInSchool = StationeryCartSchool::where('Item', $item->Item)->first();

        if (!$existingInSchool) {
            $newItemSchool = new StationeryCartSchool();
            $newItemSchool->emis = Auth::user()->username;
            $newItemSchool->ItemCode = $item->ItemCode;
            $newItemSchool->Item = $item->Item;
            $newItemSchool->save();
        }

        return redirect()->route('stationeryCat', ['requestType' => 'Stationery', 'idInbox' => 1])->with('success', 'Stationery Added Successfully');

    }

}
