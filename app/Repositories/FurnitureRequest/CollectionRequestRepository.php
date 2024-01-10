<?php

namespace App\Repositories\FurnitureRequest;

use App\Interfaces\FurnitureRequest\CollectionRequestRepositoryInterface;
use App\Models\BrokenItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\CollectionRequest;
use App\Models\RequestStatus;
use App\Models\StockCategory;
use App\Models\StockItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendEmail;
use App\Models\School;
use App\Models\SchoolDistrict;
use Symfony\Component\HttpFoundation\RequestStack;

use function PHPSTORM_META\type;

class CollectionRequestRepository implements CollectionRequestRepositoryInterface
{
    private function getUser()
    {
        return  Request::capture()->is('api/*') ? Auth::guard('api')->user() : Auth::user();
    }

    public function getAllRequest()
    {
        $data = CollectionRequest::orderby('created_at', 'desc')->paginate(10);
        if ($this->getUser()->organization == 2) {
            $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)->orderby('created_at', 'desc')->paginate(10);
        }
        if (Request::input("all")) {
            $data = CollectionRequest::orderby('created_at', 'desc')->get();
            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)->orderby('created_at', 'desc')->get();
            }
        }

        return $data;
    }

    public function getAllManageRequest()
    {
        $data = CollectionRequest::where("status_id", '=', RequestStatus::COLLECTION_PENDING)
            ->orderby('id', 'desc')->paginate(10);
        if ($this->getUser()->organization == 2) {
            $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)->where("status_id", '=', RequestStatus::COLLECTION_PENDING)
                ->orderby('id', 'desc')
                ->paginate(10);
        }

        if (Request::input("all")) {
            $data = CollectionRequest::where("status_id", '=', RequestStatus::COLLECTION_PENDING)
                ->orderby('id', 'desc')->get();
            if ($this->getUser()->organization == 2) {
                $data = CollectionRequest::where("user_id", '=', $this->getUser()->id)->where("status_id", '=', RequestStatus::COLLECTION_PENDING)
                    ->orderby('id', 'desc')
                    ->get();
            }
        }

        return $data;
    }

    public function getSchoolRequest()
    {
        $data = $this->getUser()->getRequestDetails;
        return $data;
    }

    public function checkActiveRequest()
    {
        $request = CollectionRequest::where('emis', '=', $this->getUser()->username)
            ->where('status_id', '=', 1)->first();
        $list = $request ? [
            'school_name' => $request->school_name,
            'ref_number' => $request->ref_number,
            'emis' => $request->emis,
            'total_furniture' => $request->total_furniture,
            'broken_items' => []
        ] : null;
        if ($request) {
            if (count($request->getBrokenItems) > 0) {
                foreach ($request->getBrokenItems as $item) {
                    $list['broken_items'][] =
                        [
                            "collect_req_id" => $item->collect_req_id,
                            "category_id" => $item->category_id,
                            "category_name" => StockCategory::find($item->category_id)->name,
                            "item_id" => $item->item_id,
                            "item_name" => StockItem::find($item->item_id)->name,
                            "count" => $item->count,
                        ];
                }
            }
        }

        return $list;
    }
    public function AddCollectionRequest(object $request)
    {
        //store data only 
        $user = null;
        DB::beginTransaction();
        try {
            $user = $this->getUser();
            $school = School::where('emis', '=', $user->username)->first();
            $district = SchoolDistrict::where('id', '=', $school->district_id)->first();
            $collReq = CollectionRequest::create([
                'ref_number' => $this->generateRefNumber(),
                'user_id' => $user->id,
                'school_name' => $user->name,
                'emis' =>  $user->username,
                'total_furniture' => $request->total_furniture,
                'status_id' => 1,
                'district_id' => $school->district_id,
                'district_name' => $district->district_office
            ]);
            $count = 0;
            foreach ($request->broken_items as $item) {
                $brokenItem = BrokenItem::create([
                    'collect_req_id' => $collReq->id,
                    'category_id' =>  $item['category_id'],
                    'item_id' => $item['item_id'],
                    'item_full_count' => $item['item_full_count'],
                    'count' => $item['count']
                ]);
                $count += intval($item['count']);
            }
            $collReq->total_broken_items = $count;
            $collReq->update();

            //sening mail to maufacturer while creating new request
            SendEmail::NewCollectionRequest($collReq, $request->broken_items);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $collReq = null;
            throw $th;
        }

        return $collReq;
    }

    public function EditCollectionRequest(object $request, $id)
    {
        DB::beginTransaction();
        try {
            $db_item_list = array();
            $new_item_list = array();
            $collReq = CollectionRequest::find($id);
            $item_list = BrokenItem::where('collect_req_id', '=', $collReq->id)->get();
            foreach ($item_list as $db_item) {
                array_push($db_item_list, $db_item->id);
            }
            if ($collReq->status_id == RequestStatus::COLLECTION_PENDING) {
                $collReq->total_furniture = $request->total_furniture;
                $count = 0;
                foreach ($request->broken_items as $item) {
                    if ($item['id'] == 'new-item') {
                        $brokenItem = BrokenItem::create([
                            'collect_req_id' => $collReq->id,
                            'category_id' =>  $item['category_id'],
                            'item_id' => $item['item_id'],
                            'count' => $item['count'],
                            'item_full_count' => $item['item_full_count'],
                            'old_count' => 0
                        ]);
                    } else {
                        $editBrokenItem = BrokenItem::find($item['id']);
                        array_push($new_item_list, $item['id']);
                        $editBrokenItem->old_count = $editBrokenItem->count;

                        if ($editBrokenItem->category_id != $item['category_id'] ||  $editBrokenItem->item_id != $item['item_id']) {
                            $editBrokenItem->category_id = $item['category_id'];
                            $editBrokenItem->item_id = $item['item_id'];
                            $editBrokenItem->count = $item['count'];
                            $editBrokenItem->old_count = 0;
                        }
                        $editBrokenItem->count = $item['count'];
                        $editBrokenItem->item_full_count = $item['item_full_count'];
                        $editBrokenItem->update();
                    }

                    $count += intval($item['count']);
                }
                $collReq->total_broken_items = $count;
                $collReq->update();
                $delete_list = array_diff($db_item_list, $new_item_list);
                foreach ($delete_list as $delid) {
                    $editBrokenItem = BrokenItem::find($delid)->delete();
                }
                $broken_items_list = BrokenItem::where('collect_req_id', '=', $collReq->id)->get();
                //sening mail to maufacturer while creating new request
                SendEmail::UpdateCollectionRequest($collReq, $broken_items_list);
                DB::commit();
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $collReq = null;
            throw $th;
        }

        return $collReq;
    }

    //
    protected function generateRefNumber()
    {
        $emis = $this->getUser()->username;
        $date = Carbon::now()->format('dmy');
        $userCollection = CollectionRequest::withTrashed()->where('user_id', '=', $this->getUser()->id)->get();
        $count = count($userCollection);

        $number = $emis . '_' . $date . '_' . (intval($count) + 1);
        return $number;
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
                })->orderby('id', 'desc')->paginate(10)->withQueryString();

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
                    })->orderby('id', 'desc')->paginate(10)->withQueryString();
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
                    })->orderby('id', 'desc')->paginate(10)->withQueryString();
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
                        })->orderby('id', 'desc')->paginate(10)->withQueryString();
                }
            }
        }
        return $data;
    }

    public function deleteCollectionRequest($id)
    {
        $collect = CollectionRequest::find($id);
        if ($collect->status_id == RequestStatus::COLLECTION_PENDING) {
            $collect->delete();
            return $collect;
        }
        return null;
    }
}
