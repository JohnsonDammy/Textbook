<?php

namespace App\Repositories\Reports;

use App\Interfaces\Reports\ReportsRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\ReplenishmentStatus;
use App\Models\RequestStatus;
use App\Models\StockItem;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportsRepository implements ReportsRepositoryInterface
{
    // getting authenticated user details
    private function getUser()
    {
        return  Request::capture()->is('api/*') ? Auth::guard('api')->user() : Auth::user();
    }

    // get replenishment report details
    public function getReplenishmentReport(object $request)
    {
        try {
            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where('replenishment_status', '!=', null)
                    ->where("user_id", '=', $this->getUser()->id)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->replenishment_status, function ($query) {
                        $query->where('replenishment_status', '=', request()->replenishment_status);
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            } else {
                $data = CollectionRequest::where('replenishment_status', '!=', null)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->replenishment_status, function ($query) {
                        $query->where('replenishment_status', '=', request()->replenishment_status);
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            }

            if (Request::input("all")) {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->where('replenished_count', '!=', 0)
                    ->when(request()->category_id, function ($query) {
                        $query->where('category_id', '=', request()->category_id);
                    })->when(request()->item_id, function ($query) {
                        $query->where('item_id', '=', request()->item_id);
                    })->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->get();
            } else {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->where('replenished_count', '!=', 0)
                    ->when(request()->category_id, function ($query) {

                        $query->where('category_id', '=', request()->category_id);
                    }) ->when(request()->item_id, function ($query) {
                        $query->where('item_id', '=', request()->item_id);
                    })->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->paginate(10)->withQueryString();
            }
        } catch (\Throwable $th) {
            throw $th;
            return null;
        }
        $list = [];
        if ($items) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $items->nextPageUrl(),
                    "previous_page" => $items->previousPageUrl()
                ];
            }
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $list["records"][$key] = [
                        "school_name" => $item->getCollectionDetails->school_name,
                        "school_emis" => $item->getCollectionDetails->emis,
                        "district_office" => ucwords($item->getCollectionDetails->getDistrict->district_office),
                        "ref_number" => $item->getCollectionDetails->ref_number,
                        "transaction_date" => $item->getCollectionDetails->created_at->toDateString(),
                        "furniture_category" => $item->getCategoryDetails->name,
                        "furniture_item" => $item->getItemDetails->name,
                        "replenishment_count" => $item->replenished_count,
                        "approved_replenished_count" => $item->approved_replenished_count,
                        "rejected_replenished_count" => $item->rejected_replenished_count,
                        "replenishment_status" => $item->getCollectionDetails->getReplenishStatus->name,
                        "item_full_count" => $item->item_full_count
                    ];
                }
            }
        }
        return $list;
    }

    // get disposal report details
    public function getDisposalReport(object $request)
    {
        try {
            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where('replenishment_status', '=', ReplenishmentStatus::COMPLETE)
                    ->where("user_id", '=', $this->getUser()->id)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->replenishment_status, function ($query) {
                        $query->where('replenishment_status', '=', request()->replenishment_status);
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            } else {
                $data = CollectionRequest::where('replenishment_status', '=', ReplenishmentStatus::COMPLETE)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->replenishment_status, function ($query) {
                        $query->where('replenishment_status', '=', request()->replenishment_status);
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            }

            if (Request::input("all")) {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->where('approved_replenished_count', '>', 0)
                    ->when(request()->category_id, function ($query) {
                        $query->where('category_id', '=', request()->category_id);
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->where('item_id', '=', request()->item_id);
                    })
                    ->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->get();
            } else {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->where('approved_replenished_count', '>', 0)
                    ->when(request()->category_id, function ($query) {

                        $query->where('category_id', '=', request()->category_id);
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->where('item_id', '=', request()->item_id);
                    })
                    ->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->paginate(10)->withQueryString();
            }
        } catch (\Throwable $th) {
            throw $th;
            return null;
        }
        $list = [];
        if ($items) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $items->nextPageUrl(),
                    "previous_page" => $items->previousPageUrl()
                ];
            }
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $list["records"][$key] = [
                        "school_name" => $item->getCollectionDetails->school_name,
                        "school_emis" => $item->getCollectionDetails->emis,
                        "district_office" => ucwords($item->getCollectionDetails->getDistrict->district_office),
                        "ref_number" => $item->getCollectionDetails->ref_number,
                        "transaction_date" => $item->getCollectionDetails->created_at->toDateString(),
                        "furniture_category" => $item->getCategoryDetails->name,
                        "furniture_item" => $item->getItemDetails->name,
                        "disposal_count" => $item->replenished_count,
                        "item_full_count" => $item->item_full_count
                    ];
                }
            }
        }
        return $list;
    }

    // get Manufacturer Stock management report details
    public function getManufacturerStockManagementReport(object $request)
    {
        try {
            if (Request::input("all")) {
                if ($this->getUser()->organization == 2) {
                    $data = [];
                } else {
                    $data = StockItem::when(request()->category, function ($query) {
                        $query->where('category_id', '=', request()->category);
                    })
                        ->when(request()->item, function ($query) {
                            $query->where('id', '=', request()->item);
                        })
                        ->orderBy('name', 'ASC')
                        ->get();
                }
            } else {
                if ($this->getUser()->organization == 2) {
                    $data = [];
                } else {
                    $data = StockItem::when(request()->category, function ($query) {
                        $query->where('category_id', '=', request()->category);
                    })
                        ->when(request()->item, function ($query) {
                            $query->where('id', '=', request()->item);
                        })
                        ->orderBy('name', 'ASC')
                        ->paginate(10)->withQueryString();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
            return null;
        }
        $list = [];
        if ($data) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $data->nextPageUrl(),
                    "previous_page" => $data->previousPageUrl()
                ];
            }
            if (count($data) > 0) {
                foreach ($data as $key => $stock) {
                    $list["records"][$key] = [
                        "furniture_category" => $stock->getCategory->name,
                        "furniture_item" => $stock->name,
                    ];
                }
            }
        }
        return $list;
    }

    // get School Furniture Count report details
    public function getSchoolFurnitureCountReport(object $request)
    {
        try {
            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_PENDING)
                    ->where("user_id", '=', $this->getUser()->id)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            } else {
                $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_PENDING)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            }

            if (Request::input("all")) {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->when(request()->category_id, function ($query) {

                        $query->where('category_id', '=', request()->category_id);
                    })
                    ->when(request()->item_id, function ($query) {

                        $query->where('item_id', '=', request()->item_id);
                    })->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->get();
            } else {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->when(request()->category_id, function ($query) {

                        $query->where('category_id', '=', request()->category_id);
                    })
                    ->when(request()->item_id, function ($query) {

                        $query->where('item_id', '=', request()->item_id);
                    })->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->paginate(10)->withQueryString();
            }
        } catch (\Throwable $th) {
            throw $th;
            return null;
        }
        $list = [];
        if ($items) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $items->nextPageUrl(),
                    "previous_page" => $items->previousPageUrl()
                ];
            }
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $list["records"][$key] = [
                        "school_name" => $item->getCollectionDetails->school_name,
                        "school_emis" => $item->getCollectionDetails->emis,
                        "district_office" => ucwords($item->getCollectionDetails->getDistrict->district_office),
                        "ref_number" => $item->getCollectionDetails->ref_number,
                        "transaction_date" => $item->getCollectionDetails->created_at->toDateString(),
                        "furniture_category" => $item->getCategoryDetails->name,
                        "furniture_item" => $item->getItemDetails->name,
                        "school_inventory_count" => $item->getCollectionDetails->total_furniture,
                        "collection_requested_count" => $item->count,
                        "collection_confirmed_count" => $item->confirmed_count,
                        "item_full_count" => $item->item_full_count
                    ];
                }
            }
        }
        return $list;
    }

    // get Repaiarment  report details
    public function getRepairmentReport(object $request)
    {
        try {
            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_COMPLETED)
                    ->where("user_id", '=', $this->getUser()->id)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            } else {
                $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_COMPLETED)
                    ->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                    ->when(request()->district_office, function ($query) {
                        $query->where('district_id', '=', request()->district_office);
                    })
                    ->when(request()->category_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('category_id', '=', request()->category_id);
                        });
                    })
                    ->when(request()->item_id, function ($query) {
                        $query->whereHas('getBrokenItems', function ($query) {
                            $query->where('item_id', '=', request()->item_id);
                        });
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->get();
            }

            if (Request::input("all")) {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->when(request()->category_id, function ($query) {

                        $query->where('category_id', '=', request()->category_id);
                    })
                    ->when(request()->item_id, function ($query) {

                        $query->where('item_id', '=', request()->item_id);
                    })->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->get();
            } else {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)
                    ->when(request()->category_id, function ($query) {

                        $query->where('category_id', '=', request()->category_id);
                    })
                    ->when(request()->item_id, function ($query) {

                        $query->where('item_id', '=', request()->item_id);
                    })->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderBy('collection_requests.created_at', 'DESC')->orderBy('collection_requests.district_name')->orderBy('collection_requests.school_name')->paginate(10)->withQueryString();
            }
        } catch (\Throwable $th) {
            throw $th;
            return null;
        }
        $list = [];
        if ($items) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $items->nextPageUrl(),
                    "previous_page" => $items->previousPageUrl()
                ];
            }
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $list["records"][$key] = [
                        "school_name" => $item->getCollectionDetails->school_name,
                        "school_emis" => $item->getCollectionDetails->emis,
                        "district_office" => ucwords($item->getCollectionDetails->getDistrict->district_office),
                        "ref_number" => $item->getCollectionDetails->ref_number,
                        "transaction_date" => $item->getCollectionDetails->created_at->toDateString(),
                        "furniture_category" => $item->getCategoryDetails->name,
                        "furniture_item" => $item->getItemDetails->name,
                        "repaired_count" => $item->repaired_count,
                        "item_full_count" => $item->item_full_count
                    ];
                }
            }
        }
        return $list;
    }

    // get Transaction Summery report details
    public function getTransactionSummaryReport(object $request)
    {
        try {
            if (Request::input("all")) {
                if ($this->getUser()->organization == 2) {
                    $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_PENDING)
                        ->where("user_id", '=', $this->getUser()->id)
                        ->when(request()->school_name, function ($query) {
                            $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                        })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->get();
                } else {
                    $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_PENDING)
                        ->when(request()->school_name, function ($query) {
                            $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                        })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->get();
                }
            } else {
                if ($this->getUser()->organization == 2) {
                    $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_PENDING)
                        ->where("user_id", '=', $this->getUser()->id)
                        ->when(request()->school_name, function ($query) {
                            $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                        })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->paginate(10)->withQueryString();
                } else {
                    $data = CollectionRequest::where('status_id', '>=', RequestStatus::REPAIR_PENDING)
                        ->when(request()->school_name, function ($query) {
                            $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                        })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->status_id, function ($query) {
                            $query->where('status_id', '=', request()->status_id);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->paginate(10)->withQueryString();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
            return null;
        }
        $list = [];
        if ($data) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $data->nextPageUrl(),
                    "previous_page" => $data->previousPageUrl()
                ];
            }
            if (count($data) > 0) {
                foreach ($data as $key => $request) {
                    $broken_items = BrokenItem::where('collect_req_id', '=', $request->id)->get();
                    $confirmed_collections = 0;
                    $repairs = 0;
                    $disposals = 0;
                    $approved = 0;
                    foreach ($broken_items as $item) {
                        $confirmed_collections += $item->confirmed_count;
                        if ($request->status_id >= RequestStatus::REPAIR_COMPLETED) {
                            $repairs += $item->repaired_count;
                        }
                        if ($request->replenishment_status != null) {
                            $disposals += $item->replenished_count;
                            $approved += $item->approved_replenished_count;
                        }
                    }

                    $list["records"][$key] = [
                        "school_name" => $request->school_name,
                        "school_emis" => $request->emis,
                        "reference_number" => $request->ref_number,
                        "district_office" => ucwords($request->getDistrict->district_office),
                        "confirmed_collections" => $confirmed_collections,
                        "repairs" => $repairs,
                        "disposals" =>  $disposals,
                        "approved" => $approved
                    ];
                }
            }
        }
        return $list;
    }

    // get Transaction Status report details
    public function getTransactionStatusReport(object $request)
    {
        try {
            if (Request::input("all")) {
                if ($this->getUser()->organization == 2) {
                    $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)
                        ->when(request()->school_name, function ($query) {
                            $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                        })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->status_id, function ($query) {
                            $query->where('status_id', '=', request()->status_id);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->get();
                } else {
                    $data = CollectionRequest::when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->status_id, function ($query) {
                            $query->where('status_id', '=', request()->status_id);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->get();
                }
            } else {
                if ($this->getUser()->organization == 2) {
                    $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)
                        ->when(request()->school_name, function ($query) {
                            $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                        })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->status_id, function ($query) {
                            $query->where('status_id', '=', request()->status_id);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->paginate(10)->withQueryString();
                } else {
                    $data = CollectionRequest::when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                        ->when(request()->district_office, function ($query) {
                            $query->where('district_id', '=', request()->district_office);
                        })
                        ->when(request()->status_id, function ($query) {
                            $query->where('status_id', '=', request()->status_id);
                        })
                        ->when(request()->start_date, function ($query) {
                            $date = request()->end_date;
                            if (request()->end_date == null) {
                                $date = Carbon::now()->format('Y-m-d');
                            }
                            $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                        })->orderBy('created_at', 'DESC')->paginate(10)->withQueryString();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
            return null;
        }
        $list = [];
        if ($data) {
            if (!Request::input("all")) {
                $list = [
                    "next_page" => $data->nextPageUrl(),
                    "previous_page" => $data->previousPageUrl()
                ];
            }
            if (count($data) > 0) {
                foreach ($data as $key => $request) {
                    $list["records"][$key] = [
                        "school_name" => $request->school_name,
                        "school_emis" => $request->emis,
                        "district_office" => ucwords($request->getDistrict->district_office),
                        "ref_number" => $request->ref_number,
                        "transaction_date" => $request->created_at->toDateString(),
                        "transaction_status" =>  $request->getRequestStatus->name,
                        "transaction_status_id" =>  $request->status_id,
                        "replenishment_proof" => $request->getUploadReplenishmentProof ? $this->getReplenishmentProof($request)  : "NA",
                        "delivery_note" => $request->getUploadDeliveryNote ? $this->getDeliveryNote($request) : "NA",
                        "evidence_images" => $request->getRequestImages ? $this->evidenceImageList($request) : "NA",
                        "disposal_images" => $request->getRequestImages ? $this->disposalImagesImageList($request) : "NA",

                    ];
                }
            }
        }
        return $list;
    }

    // getting Evidence image list for Collection request
    private function evidenceImageList($request)
    {
        $list = [];
        if (!empty($request->getRequestImages)) {
            foreach ($request->getRequestImages as $key => $value) {
                $list[] = [
                    "id" => $value->id,
                    "file_type" => pathinfo(asset(Storage::url($value->image_path)), PATHINFO_EXTENSION),
                    "path" => asset(Storage::url($value->image_path))
                ];
            }
        }
        return $list;
    }

    private function disposalImagesImageList($request)
    {
        $list = [];
        if (!empty($request->getDisplosalImages)) {
            foreach ($request->getDisplosalImages as $key => $value) {
                $list[] = [
                    "id" => $value->id,
                    "file_type" => pathinfo(asset(Storage::url($value->image_path)), PATHINFO_EXTENSION),
                    "path" => asset(Storage::url($value->image_path))
                ];
            }
        }
        return $list;
    }
    // getting Replenishment proof for collection request
    private function getReplenishmentProof($request)
    {
        $file =  $request->getUploadReplenishmentProof;
        return [
            "id" => $file->id,
            "file_type" => pathinfo(asset(Storage::url($file->path)), PATHINFO_EXTENSION),
            "path" => asset(Storage::url($file->path))
        ];
    }

    // getting Delivery note for the Collection request
    private function getDeliveryNote($request)
    {
        $file = $request->getUploadDeliveryNote;
        return  [
            "id" => $file->id,
            "file_type" => pathinfo(asset(Storage::url($file->path)), PATHINFO_EXTENSION),
            "path" => asset(Storage::url($file->path))
        ];
    }
}
