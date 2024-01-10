<?php

namespace App\Repositories;

use App\Interfaces\SearchRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\RequestStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SearchRepository implements SearchRepositoryInterface
{

    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private function getUser()
    {
        return  Request::capture()->is('api/*') ? Auth::guard('api')->user() : Auth::user();
    }

    public function searchRequest(object $request)
    {
        if ($request->school_name == null && $request->ref_number == null && $request->emis == null && $request->school_name == null && $request->status_id == null && $request->start_date == null && $request->end_date == null) {
            $data = [];
        } else {
            $data = CollectionRequest::when(request()->school_name, function ($query) {
                $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
            })
                ->when(request()->ref_number, function ($query) {
                    $query->where('ref_number', 'LIKE', '%' . request()->ref_number . '%');
                })
                ->when(request()->emis, function ($query) {
                    $query->where('emis', 'LIKE', '%' . request()->emis . '%');
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
                })->orderby('created_at', 'DESC')->paginate(10)->withQueryString();

            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)->when(request()->school_name, function ($query) {
                    $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                })
                    ->when(request()->ref_number, function ($query) {
                        $query->where('ref_number', 'LIKE', '%' . request()->ref_number . '%');
                    })
                    ->when(request()->emis, function ($query) {
                        $query->where('emis', 'LIKE', '%' . request()->emis . '%');
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
                    })->orderby('created_at', 'DESC')->paginate(10)->withQueryString();
            }
            if (Request::capture()->is('api/*')) {
                $data = CollectionRequest::when(request()->school_name, function ($query) {
                    $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                })
                    ->when(request()->ref_number, function ($query) {
                        $query->where('ref_number', 'LIKE', '%' . request()->ref_number . '%');
                    })
                    ->when(request()->emis, function ($query) {
                        $query->where('emis', 'LIKE', '%' . request()->emis . '%');
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
                    })->orderby('created_at', 'DESC')->paginate(10)->withQueryString();
                if ($this->getUser()->organization == 3) {
                    $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)->when(request()->school_name, function ($query) {
                        $query->where('school_name', 'LIKE', '%' . request()->school_name . '%');
                    })
                        ->when(request()->ref_number, function ($query) {
                            $query->where('ref_number', 'LIKE', '%' . request()->ref_number . '%');
                        })
                        ->when(request()->emis, function ($query) {
                            $query->where('emis', 'LIKE', '%' . request()->emis . '%');
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
                        })->orderby('created_at', 'DESC')->paginate(10)->withQueryString();
                }
            }
        }
        return $data;
    }

    public function searchRequestItems(object $request)
    {
        try {
            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)
                    ->when(request()->ref_number, function ($query) {
                        $query->where('ref_number', 'LIKE', '%' . request()->ref_number . '%');
                    })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->orderby('created_at', 'DESC')->get();
            } else {
                $data = CollectionRequest::when(request()->ref_number, function ($query) {
                    $query->where('ref_number', 'LIKE', '%' . request()->ref_number . '%');
                })
                    ->when(request()->start_date, function ($query) {
                        $date = request()->end_date;
                        if (request()->end_date == null) {
                            $date = Carbon::now()->format('Y-m-d');
                        }
                        $query->whereBetween('created_at', array(request()->start_date . " 00:00:00", $date . " 23:59:59"));
                    })->orderby('created_at', 'DESC')->get();
            }

            if (Request::input("all")) {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderby('collection_requests.created_at', 'desc')->get();
            } else {
                $collection_list = [];
                foreach ($data as $request) {
                    $collection_list[] = $request->id;
                }
                $items = BrokenItem::whereIn('collect_req_id', $collection_list)->join('collection_requests', 'collection_requests.id', '=', 'broken_items.collect_req_id')->orderby('collection_requests.created_at', 'desc')->paginate(10)->withQueryString();
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
                        "id" => $item->id,
                        "collection_id" => $item->getCollectionDetails->id,
                        "user_id" =>  $item->getCollectionDetails->user_id,
                        "school_name" => $item->getCollectionDetails->school_name,
                        "emis" => $item->getCollectionDetails->emis,
                        "ref_number" => $item->getCollectionDetails->ref_number,
                        "created_at" => $item->getCollectionDetails->created_at->toDateString(),
                        "total_furniture" => $item->getCollectionDetails->total_furniture,
                        "status" => $item->getCollectionDetails->getRequestStatus->name,
                        "status_id" => $item->getCollectionDetails->status_id,
                        "replenishment_status" => $item->getCollectionDetails->replenishment_status,
                        "total_broken_items" => $item->getCollectionDetails->total_broken_items,
                        "category_id" => $item->category_id,
                        "category_name" => $item->getCategoryDetails->name,
                        "item_id" => $item->item_id,
                        "item_name" => $item->getItemDetails->name,
                        "status" => $item->getCollectionDetails->getRequestStatus->name,
                        "count" => $item->count,
                        "confirmed_count" => $item->getCollectionDetails->status_id >= RequestStatus::REPAIR_PENDING ? $item->confirmed_count : false,
                        'repaired_count' => $item->repaired_count,
                        'replenished_count' => $item->replenished_count,
                        'delivered_count' => $item->delivered_count,
                    ];
                }
            }
        }
        return $list;
    }
}
