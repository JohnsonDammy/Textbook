<?php

namespace App\Repositories;

use App\Interfaces\DashboardRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\ReplenishmentStatus;
use App\Models\RequestStatus;
use App\Models\inbox;
use App\Models\inbox_school;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getTotalCount()
    {

        $user = Auth::user()->username;
        $district_id = User::where('username', $user)->value('District_id');

        //SELECT COUNT(*) FROM `inbox` WHERE RequestType ="TextbookAndStationary" and District_Id =1;

        //1.	How many schools used allocated funds
        //SELECT * FROM `inbox` where RequestType ="Allocation Funds" and District_Id =1;
        //SELECT DISTINCT count(school_emis) FROM `inbox_school` where status ="Quote Received" and district_id =1 group by school_emis;
        //SELECT DISTINCT count(school_emis) FROM `inbox_school` where status ="Quote Requested" and district_id =1 group by school_emis;

        $TextbookCount = inbox::where('RequestType', '=', "Textbook")->where('District_Id' , $district_id)->get()->count();
        $TextbookAndStationaryCount = inbox::where('RequestType', '=', "TextbookAndStationary")->where('District_Id' , $district_id)->get()->count();
        $StationaryCount = inbox::where('RequestType', '=', "Stationary")->where('District_Id' , $district_id)->get()->count();
        $AllocationFundsSchoolCount = inbox::where('RequestType', '=', "Allocation Funds")->where('District_Id' , $district_id)->get()->count();
        $SchoolQuoteRequestedCount = inbox_school::where('status', '=', 'Quote Requested')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();

        $SchoolQuoteRecieveCount = inbox_school::where('status', '=', 'Quote Received')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();
    
        $totalCount = [
            'TextbookCount' => $TextbookCount,
            'TextbookAndStationaryCount' => $TextbookAndStationaryCount,
            'StationaryCount' => $StationaryCount,
            'AllocationFundsSchoolCount' => $AllocationFundsSchoolCount,
            'SchoolQuoteRequestedCount' => $SchoolQuoteRequestedCount,
            'SchoolQuoteRecieveCount' => $SchoolQuoteRecieveCount

        ];
        return $totalCount;
    }

    public function getPendingCollections()
    {
        $today = Carbon::now();
        $list = [];
        if (Request::input("all")) {
            $collections = CollectionRequest::where('status_id', '=', RequestStatus::COLLECTION_PENDING)->get();
        } else {
            $collections = CollectionRequest::where('status_id', '=', RequestStatus::COLLECTION_PENDING)->paginate(10);
        }

        if ($collections) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $collections->nextPageUrl(),
                    "previous_page" => $collections->previousPageUrl()
                ];
            }
            if (count($collections) > 0) {
                foreach ($collections as $key => $request) {
                    $list["records"][$key] = [
                        "school_name" => $request->school_name,
                        "collection_count" => $request->total_broken_items,
                        "date_created" => $request->created_at->toDateString(),
                        "days_in_waiting" => $request->created_at->diffInDays($today)
                    ];
                }
            }
        }
        return $list;
    }

    public function getYtdStatusCount()
    {

        $user = Auth::user()->username;
        $district_id = User::where('username', $user)->value('District_id');

        $total  = $TextbookCount = $TextbookAndStationaryCount = $StationaryCount = $AllocationFundsSchoolCount = $SchoolQuoteRequestedCount = $SchoolQuoteRecieveCount = 0;

        
        $TextbookCount = inbox::where('RequestType', '=', "Textbook")->where('District_Id' , $district_id)->get()->count();
        $TextbookAndStationaryCount = inbox::where('RequestType', '=', "TextbookAndStationary")->where('District_Id' , $district_id)->get()->count();
        $StationaryCount = inbox::where('RequestType', '=', "Stationary")->where('District_Id' , $district_id)->get()->count();
        $AllocationFundsSchoolCount = inbox::where('RequestType', '=', "Allocation Funds")->where('District_Id' , $district_id)->get()->count();
        $SchoolQuoteRequestedCount = inbox_school::where('status', '=', 'Quote Requested')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();

        $SchoolQuoteRecieveCount = inbox_school::where('status', '=', 'Quote Received')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();
        
        
        $ytdStatusCount = [
            'TextbookCount' => $TextbookCount,
            'StationaryCount' => $StationaryCount,

            'TextbookAndStationaryCount' => $TextbookAndStationaryCount,
            'AllocationFundsSchoolCount' => $AllocationFundsSchoolCount,
            'SchoolQuoteRequestedCount' => $SchoolQuoteRequestedCount,
            'SchoolQuoteRecieveCount' => $SchoolQuoteRecieveCount,
   
        ];
        return $ytdStatusCount;
    }

    public function getYtdStatusCountReport()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $collection_list = [];
        $list = [];
        if ($month > 3) {
            $collections = CollectionRequest::whereBetween('created_at', array($year . "-04-01 00:00:00", $year + 1 . "-03-31 23:59:59"))->get();
        } else {
            $collections = CollectionRequest::whereBetween('created_at', array($year - 1 . "-04-01 00:00:00", $year . "-03-31 23:59:59"))->get();
        }

        if ($collections) {
            if (count($collections) > 0) {
                foreach ($collections as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)->get();
            }
            if ($items) {
                if (count($items) > 0) {
                    foreach ($items as $key => $item) {
                        $status = null;
                        if ($item->getCollectionDetails->status_id == RequestStatus::REPAIR_PENDING && $item->getCollectionDetails->replenishment_status != null) {
                            $status = $item->getCollectionDetails->getReplenishStatus->name;
                        } else {
                            $status = $item->getCollectionDetails->getRequestStatus->name;
                        }
                        $list["records"][$key] = [
                            "school_name" => $item->getCollectionDetails->school_name,
                            "school_emis_number" => $item->getCollectionDetails->emis,
                            "district_office" => ucwords($item->getCollectionDetails->getDistrict->district_office),
                            "transaction_reference_number" => $item->getCollectionDetails->ref_number,
                            "created_date" => $item->getCollectionDetails->created_at->toDateString(),
                            "furniture_category" => $item->getCategoryDetails->name,
                            "furniture_item" => $item->getItemDetails->name,
                            "transaction_status" => $status
                        ];
                    }
                }
            }
        }
        return $list;
    }

    public function getProgressCollectionCount()
    {

        $user = Auth::user()->username;
        $district_id = User::where('username', $user)->value('District_id');

        $total  = $TextbookCount = $TextbookAndStationaryCount = $StationaryCount = $AllocationFundsSchoolCount = $SchoolQuoteRequestedCount = $SchoolQuoteRecieveCount = 0;

        
        $TextbookCount = inbox::where('RequestType', '=', "Textbook")->where('District_Id' , $district_id)->get()->count();
        $TextbookAndStationaryCount = inbox::where('RequestType', '=', "TextbookAndStationary")->where('District_Id' , $district_id)->get()->count();
        $StationaryCount = inbox::where('RequestType', '=', "Stationary")->where('District_Id' , $district_id)->get()->count();
        $AllocationFundsSchoolCount = inbox::where('RequestType', '=', "Allocation Funds")->where('District_Id' , $district_id)->get()->count();
        $SchoolQuoteRequestedCount = inbox_school::where('status', '=', 'Quote Requested')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();

        $SchoolQuoteRecieveCount = inbox_school::where('status', '=', 'Quote Received')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();
    



        $total = $TextbookCount +  $TextbookAndStationaryCount + $StationaryCount + $AllocationFundsSchoolCount + $SchoolQuoteRequestedCount + $SchoolQuoteRecieveCount;
        if ($total == 0) {
            $total = 1;
        }


        $list = [
            // "pending_repairs" => number_format(($pending_repairs / $total) * 100, 2),

            
            "Textbook" => number_format(($TextbookCount  / $total) * 100, 2),
             "Textbook & Stationery" => number_format(($TextbookAndStationaryCount / $total) * 100, 2 ),
             "Stationery" => number_format(($StationaryCount / $total) * 100, 2),
            "AllocationFunds" => number_format(($AllocationFundsSchoolCount / $total) * 100 , 2),
            "Quote Requested" => number_format(($SchoolQuoteRequestedCount / $total) * 100 , 2),
            "Quote Received" => number_format(($SchoolQuoteRecieveCount / $total) * 100 , 2),

     
            
        ];
        return $list;
    }

    public function previousYearStatusCount()
    {
        $user = Auth::user()->username;
        $district_id = User::where('username', $user)->value('District_id');

        $total  = $TextbookCount = $TextbookAndStationaryCount = $StationaryCount = $AllocationFundsSchoolCount = $SchoolQuoteRequestedCount = $SchoolQuoteRecieveCount = 0;

        
        $TextbookCount = inbox::where('RequestType', '=', "Textbook")->where('District_Id' , $district_id)->get()->count();
        $TextbookAndStationaryCount = inbox::where('RequestType', '=', "TextbookAndStationary")->where('District_Id' , $district_id)->get()->count();
        $StationaryCount = inbox::where('RequestType', '=', "Stationary")->where('District_Id' , $district_id)->get()->count();
        $AllocationFundsSchoolCount = inbox::where('RequestType', '=', "Allocation Funds")->where('District_Id' , $district_id)->get()->count();
        $SchoolQuoteRequestedCount = inbox_school::where('status', '=', 'Quote Requested')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();

        $SchoolQuoteRecieveCount = inbox_school::where('status', '=', 'Quote Received')->where('district_id', $district_id)->groupBy('school_emis')
        ->get(['school_emis', DB::raw('COUNT(*) as emis_count')])
        ->count();
        
        $previousYearCount = [
            'Textbook' => $TextbookCount,
            'Stationery' => $StationaryCount,
            'Textbook & Stationery' => $TextbookAndStationaryCount,
            'AllocationFunds' => $AllocationFundsSchoolCount,
            'Quote Requested' => $SchoolQuoteRequestedCount,
            'Quote Received' => $SchoolQuoteRecieveCount,

        ];
        return $previousYearCount;
    }

    public function getpreviousYearCountReport()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $collection_list = [];
        $list = [];
        if ($month > 3) {
            $data = CollectionRequest::whereBetween('created_at', array($year - 1 . "-04-01 00:00:00", $year . "-03-31 23:59:59"))->get();
        } else {
            $data = CollectionRequest::whereBetween('created_at', array($year - 2 . "-04-01 00:00:00", $year - 1 . "-03-31 23:59:59"))->get();
        }

        if ($data) {
            if (count($data) > 0) {
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)->get();
                if ($items) {
                    if (count($items) > 0) {
                        foreach ($items as $key => $item) {
                            $status = null;
                            if ($item->getCollectionDetails->status_id == RequestStatus::REPAIR_PENDING && $item->getCollectionDetails->replenishment_status != null) {
                                $status = $item->getCollectionDetails->getReplenishStatus->name;
                            } else {
                                $status = $item->getCollectionDetails->getRequestStatus->name;
                            }
                            $list["records"][$key] = [
                                "school_name" => $item->getCollectionDetails->school_name,
                                "school_emis_number" => $item->getCollectionDetails->emis,
                                "district_office" => ucwords($item->getCollectionDetails->getDistrict->district_office),
                                "transaction_reference_number" => $item->getCollectionDetails->ref_number,
                                "created_date" => $item->getCollectionDetails->created_at->toDateString(),
                                "furniture_category" => $item->getCategoryDetails->name,
                                "furniture_item" => $item->getItemDetails->name,
                                "transaction_status" => $status
                            ];
                        }
                    }
                }
            }
        }
        return $list;
    }
}
