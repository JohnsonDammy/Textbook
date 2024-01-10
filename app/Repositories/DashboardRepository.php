<?php

namespace App\Repositories;

use App\Interfaces\DashboardRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\ReplenishmentStatus;
use App\Models\RequestStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getTotalCount()
    {
        $pendingCollection = CollectionRequest::where('status_id', '=', RequestStatus::COLLECTION_PENDING)->get()->count();
        $totalDeliveries = CollectionRequest::where('status_id', '=', RequestStatus::DELIVERY_CONFIRMED)->get()->count();
        $pendingReplenishments = CollectionRequest::where('replenishment_status', '=', ReplenishmentStatus::PENDING)->get()->count();
        $pendingRepairs = CollectionRequest::where('status_id', '=', RequestStatus::REPAIR_PENDING)->get()->count();
        $pendingDeliveries = CollectionRequest::where('status_id', '=', RequestStatus::DELIVERY_PENDING)->get()->count();

        $totalCount = [
            'pending_collection' => $pendingCollection,
            'total_deliveries' => $totalDeliveries,
            'pending_replenishments' => $pendingReplenishments,
            'pending_repairs' => $pendingRepairs,
            'pending_deliveries' => $pendingDeliveries
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
        $rejectReplenishments = $approveReplenishments = $partialReplenishments = $repairCompleted = $pendingReplenishments = $pendingRepairs = $pendingDeliveries = $pendingCollection = $deliveryConfirmed = $collectionAccept = 0;
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        if ($month > 3) {
            $data = CollectionRequest::whereBetween('created_at', array($year . "-04-01 00:00:00", $year + 1 . "-03-31 23:59:59"))->get();
        } else {
            $data = CollectionRequest::whereBetween('created_at', array($year - 1 . "-04-01 00:00:00", $year . "-03-31 23:59:59"))->get();
        }
        if (count($data) > 0) {
            foreach ($data as $request) {
                $approveCountSum = 0;
                $repCountSum = 0;
                switch ($request->status_id) {
                    case (RequestStatus::COLLECTION_PENDING):
                        $pendingCollection++;
                        break;

                    case (RequestStatus::COLLECTION_ACCEPTED):
                        $collectionAccept++;
                        break;

                    case (RequestStatus::REPAIR_PENDING):
                        $pendingRepairs++;
                        break;

                    case (RequestStatus::REPAIR_COMPLETED):
                        $repairCompleted++;
                        break;

                    case (RequestStatus::DELIVERY_PENDING):
                        $pendingDeliveries++;
                        break;

                    case (RequestStatus::DELIVERY_CONFIRMED):
                        $deliveryConfirmed++;
                        break;

                    default:
                        $msg = 'Something went wrong.';
                }
                switch ($request->replenishment_status) {
                    case (ReplenishmentStatus::PENDING):
                        $pendingReplenishments++;
                        break;

                    case (ReplenishmentStatus::COMPLETE):
                        $itemList = BrokenItem::where('collect_req_id', '=', $request->id)->get();
                        foreach ($itemList as $li) {
                            $approveCountSum += $li->approved_replenished_count;
                            $repCountSum += $li->replenished_count;
                        }
                        if ($repCountSum != 0) {
                            if ($approveCountSum == 0) {
                                $rejectReplenishments++;
                            } else {
                                if ($approveCountSum == $repCountSum) {
                                    $approveReplenishments++;
                                } else {
                                    $partialReplenishments++;
                                }
                            }
                        }
                        break;

                    default:
                        $msg = 'Something went wrong.';
                }
            }
        }
        $ytdStatusCount = [
            'pending_collection' => $pendingCollection,
            'collection_accepted' => $collectionAccept,
            'pending_repairs' => $pendingRepairs,
            'repair_completed' => $repairCompleted,
            'pending_replenishment' => $pendingReplenishments,
            'replenishment_approved' => $approveReplenishments,
            'replenishment_rejected' => $rejectReplenishments,
            'partial_replenishment' => $partialReplenishments,
            'pending_delivery' => $pendingDeliveries,
            'delivery_confirmed' => $deliveryConfirmed
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
        $total  = $delivery_confirmed = $pending_delivery = $pending_repairs = $pending_replenishment_approval = $repair_completed = $replenishment_approved = $replenishment_rejected = 0;

        $broken_items = BrokenItem::all();
        foreach ($broken_items as $key => $value) {
            $collection =  $value->getCollectionDetails;
            if ($collection) {

                // $total += $value->confirmed_count;

                if ($collection->status_id == RequestStatus::REPAIR_PENDING) {
                    if ($collection->replenishment_status != null) {
                        if ($collection->replenishment_status == ReplenishmentStatus::PENDING) {
                            $pending_replenishment_approval += $value->replenished_count;
                        }
                        $pending_repairs += $value->repaired_count;
                    } else {
                        $pending_repairs += $value->confirmed_count;
                    }
                }

                if ($collection->replenishment_status == ReplenishmentStatus::COMPLETE) {
                    $replenishment_approved += $value->approved_replenished_count;
                    $replenishment_rejected += $value->rejected_replenished_count;
                }

                if ($collection->status_id == RequestStatus::REPAIR_COMPLETED) {
                    $repair_completed += $value->repaired_count;
                }

                if ($collection->status_id == RequestStatus::DELIVERY_PENDING) {
                    $pending_delivery += $value->delivered_count;
                }

                if ($collection->status_id == RequestStatus::DELIVERY_CONFIRMED) {
                    $delivery_confirmed += $value->delivered_count;
                }
            }
        }

        $total = $delivery_confirmed +  $pending_delivery + $pending_repairs + $pending_replenishment_approval + $repair_completed + $replenishment_approved + $replenishment_rejected;
        if ($total == 0) {
            $total = 1;
        }
        $list = [
            
            "pending_repairs" => number_format(($pending_repairs / $total) * 100, 2),
             "repair_completed" => number_format(($repair_completed / $total) * 100, 2),
             "pending_replenishment_approval" => number_format(($pending_replenishment_approval / $total) * 100, 2),
            "replenishment_approved" => number_format(($replenishment_approved / $total) * 100, 2),
            "replenishment_rejected" => number_format(($replenishment_rejected / $total) * 100, 2),
            "pending_delivery" => number_format(($pending_delivery / $total) * 100, 2),
            "delivery_confirmed" => number_format(($delivery_confirmed / $total) * 100, 2),
            
        ];
        return $list;
    }

    public function previousYearStatusCount()
    {
        $rejectReplenishments = $approveReplenishments = $partialReplenishments = $repairCompleted = $pendingReplenishments = $pendingRepairs = $pendingDeliveries = $pendingCollection = $deliveryConfirmed = $collectionAccept = 0;
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        if ($month > 3) {
            $data = CollectionRequest::whereBetween('created_at', array($year - 1 . "-04-01 00:00:00", $year . "-03-31 23:59:59"))->get();
        } else {
            $data = CollectionRequest::whereBetween('created_at', array($year - 2 . "-04-01 00:00:00", $year - 1 . "-03-31 23:59:59"))->get();
        }
        if (count($data) > 0) {
            foreach ($data as $request) {
                $approveCountSum = 0;
                $repCountSum = 0;
                switch ($request->status_id) {
                    case (RequestStatus::COLLECTION_PENDING):
                        $pendingCollection++;
                        break;

                    case (RequestStatus::COLLECTION_ACCEPTED):
                        $collectionAccept++;
                        break;

                    case (RequestStatus::REPAIR_PENDING):
                        $pendingRepairs++;
                        break;

                    case (RequestStatus::REPAIR_COMPLETED):
                        $repairCompleted++;
                        break;

                    case (RequestStatus::DELIVERY_PENDING):
                        $pendingDeliveries++;
                        break;

                    case (RequestStatus::DELIVERY_CONFIRMED):
                        $deliveryConfirmed++;
                        break;

                    default:
                        $msg = 'Something went wrong.';
                }
                switch ($request->replenishment_status) {
                    case (ReplenishmentStatus::PENDING):
                        $pendingReplenishments++;
                        break;

                    case (ReplenishmentStatus::COMPLETE):
                        $itemList = BrokenItem::where('collect_req_id', '=', $request->id)->get();
                        foreach ($itemList as $li) {
                            $approveCountSum += $li->approved_replenished_count;
                            $repCountSum += $li->replenished_count;
                        }
                        if ($repCountSum != 0) {
                            if ($approveCountSum == 0) {
                                $rejectReplenishments++;
                            } else {
                                if ($approveCountSum == $repCountSum) {
                                    $approveReplenishments++;
                                } else {
                                    $partialReplenishments++;
                                }
                            }
                        }

                        break;

                    default:
                        $msg = 'Something went wrong.';
                }
            }
        }
        $previousYearCount = [
            'pending_collection' => $pendingCollection,
            'collection_accepted' => $collectionAccept,
            'pending_repairs' => $pendingRepairs,
            'repair_completed' => $repairCompleted,
            'pending_replenishment' => $pendingReplenishments,
            'replenishment_approved' => $approveReplenishments,
            'replenishment_rejected' => $rejectReplenishments,
            'partial_replenishment' => $partialReplenishments,
            'pending_delivery' => $pendingDeliveries,
            'delivery_confirmed' => $deliveryConfirmed

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
