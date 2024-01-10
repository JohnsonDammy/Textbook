<?php

namespace App\Repositories;

use App\Helpers\SendEmail;
use App\Interfaces\AnnexureRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\ReplenishmentStatus;
use App\Models\RequestStatus;
use App\Models\School;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use PDF as PDF;

class AnnexureRepository implements AnnexureRepositoryInterface
{
    //defining and wrinting function to print annexure a
    public function printAnnexureA($request)
    {
        //getting collection request data with the help of ref_number in database
        $data = CollectionRequest::where('ref_number', '=', $request->ref_number)->first();

        //checking whether collection request is exist or not in database and also checking collection request status is pending
        if ($data && $data->status_id != RequestStatus::COLLECTION_PENDING) {
            $school = School::where('emis', '=', $data->emis)->first();
            //assigning district name to object for passing to view
            $data->district = $school->getDistrict->district_office;
            //loading view for web
            $pdf = PDF::loadView('annexures.annexure-a', ['data' => $data]);


            if (Request::capture()->is('api/*')) {
                return view('annexures.annexure-a', ['data' => $data]);
            }
            //returning pdf object to direct download annexure pdf
            return $pdf;
        }
        return null;
    }
    public function printAnnexureB($request)
    {
        try {
            $collection = CollectionRequest::where('ref_number', $request->ref_number)->first();
            if (!$collection || $collection->status_id < RequestStatus::REPAIR_PENDING) {
                return null;
            }
            $school = School::where('emis', '=', $collection->emis)->first();
            $collection->district = $school->getDistrict->district_office;
            $collection->school_name = $school->name;
            //passing data to view 
            $data = (object)[
                "school" => $collection,
                "items" => $request->items

            ];
            $pdf = PDF::loadView('annexures.annexure-b', ["data" => $data]);
            if ($request->is('api/*')) {
                return view('annexures.annexure-b', ["data" => $data]);
            }
            return $pdf;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function printAnnexureC($request)
    {
        DB::beginTransaction();
        try {
            $collection = CollectionRequest::where('ref_number', $request->ref_number)->first();
            if (!$collection || $collection->status_id < RequestStatus::REPAIR_PENDING) {
                return null;
            }


            foreach ($request->items as $item) {
                $broken_item = BrokenItem::where('id', $item['id'])->first();
                $broken_item->replenished_count = $item['replenish_count'];
                $broken_item->repaired_count = $item['repair_count'];
                $broken_item->update();
            }

            $db_items = BrokenItem::where('collect_req_id', $collection->id)->get();


            //updating replenishment status ti pending
            $collection->replenishment_status =  ReplenishmentStatus::PENDING;
            $collection->update();

            $school = School::where('emis', '=', $collection->emis)->first();
            $collection->district = $school->getDistrict->district_office;
            $collection->school_name = $school->name;

            $data = (object)[
                "school" => $collection,
                "items" => $db_items
            ];
            DB::commit();
            $pdf = PDF::loadView('annexures.annexure-c', ["data" => $data]);
            SendEmail::sendReplenishRquestForm($data);

            if (Request::capture()->is('api/*')) {
                return view('annexures.annexure-c', ["data" => $data]);
            }
            return $pdf;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function printAnnexureD($request)
    {
        DB::beginTransaction();
        try {
            $collection = CollectionRequest::where('ref_number', $request->ref_number)->first();
            if (!$collection || $collection->status_id < RequestStatus::REPAIR_COMPLETED) {
                return null;
            }


            // foreach ($request->items as $item) {
            //     $broken_item = BrokenItem::where('id', $item['id'])->first();
            //     $broken_item->delivered_count = $item['deliver_count'];
            //     $broken_item->update();
            // }

            
            $db_items = BrokenItem::where('collect_req_id', $collection->id)->get();

            //Updating collection request to Dellivery pending
            $collection->status_id =  RequestStatus::DELIVERY_PENDING;
            $collection->update();

            $school = School::where('emis', '=', $collection->emis)->first();
            $collection->district = $school->getDistrict->district_office;
            $collection->school_name = $school->name;

            $data = (object)[
                "school" => $collection,
                "items" => $db_items
            ];
            DB::commit();
            $pdf = PDF::loadView('annexures.annexure-d', ["data" => $data]);

            //sending email for delivery notification
            SendEmail::SendDeliveryNotification($data);

            if (Request::capture()->is('api/*')) {
                return view('annexures.annexure-d', ["data" => $data]);
            }
            return $pdf;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
