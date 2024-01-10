<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchByDateRangeRequest;
use App\Http\Requests\Search\SearchByRefNumberRequest;
use App\Interfaces\SearchRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\RequestStatus;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    private SearchRepositoryInterface $searchgRepo;

    function __construct(SearchRepositoryInterface $searchgRepo)
    {
        $this->searchgRepo = $searchgRepo;
    }

    public function index(Request $request)
    {
        try {
            $list = $this->searchgRepo->searchRequestItems($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Collection request list" : "No data found", "data" => $list],  !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // search request by reference number
    public function byReferenceNumber(SearchByRefNumberRequest $request)
    {
        try {
            $list = $this->searchgRepo->searchRequestItems($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Collection request list" : "Your search did not match any records.", "data" => $list],  !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // search request by date range
    public function byDateRange(SearchByDateRangeRequest $request)
    {
        try {
            $list = $this->searchgRepo->searchRequestItems($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Collection request list" : "Your search did not match any records.", "data" => $list],  !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }



    protected function list(object $collection)
    {
        $brokenItems = BrokenItem::where("collect_req_id", $collection->id)->get();
        return [
            "id" => $collection->id,
            "ref_number" => $collection->ref_number,
            "user_id" => $collection->user_id,
            "school_name" => $collection->school_name,
            "emis" => $collection->emis,
            "total_furniture" => $collection->total_furniture,
            "status" => $collection->getRequestStatus->name,
            "status_id" => $collection->status_id,
            "replenishment_status" => $collection->replenishment_status,
            "total_broken_items" => $collection->total_broken_items,
            "created_at" => $collection->created_at->format('Y-m-d'),
            "broken_items" => $this->brokenItemList($brokenItems)
        ];
    }

    protected function brokenItemList(object $item)
    {
        $list = [];
        foreach ($item as $key => $value) {
            $list[] = [
                "id" => $value->id,
                "collection_req_id" => $value->collect_req_id,
                "category_id" => $value->category_id,
                "category_name" => $value->getCategoryDetails->name,
                "item_id" => $value->item_id,
                "item_name" => $value->getItemDetails->name,
                "count" => $value->count,
                "confirmed_count" => $value->getCollectionDetails->status_id >= RequestStatus::REPAIR_PENDING ? $value->confirmed_count : false,
                'repaired_count' => $value->repaired_count,
                'replenished_count' => $value->replenished_count,
                'delivered_count' => $value->delivered_count,
            ];
        }
        return $list;
    }
}
