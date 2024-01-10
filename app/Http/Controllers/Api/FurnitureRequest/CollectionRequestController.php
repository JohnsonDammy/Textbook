<?php

namespace App\Http\Controllers\Api\FurnitureRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionRequestSearch;
use App\Http\Requests\FurnitureCollection\StoreFurnitureCollection;
use App\Interfaces\FurnitureRequest\CollectionRequestRepositoryInterface;
use App\Interfaces\SearchRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Http\Requests\FurnitureCollection\UpdateFurnitureCollection;
use App\Models\RequestStatus;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class CollectionRequestController extends Controller
{
    private CollectionRequestRepositoryInterface $collectionRequestRepository;
    private SearchRepositoryInterface $searchRepository;

    function __construct(CollectionRequestRepositoryInterface $collectionRequestRepository, SearchRepositoryInterface $searchRepository)
    {
        $this->collectionRequestRepository = $collectionRequestRepository;
        $this->searchRepository = $searchRepository;
        $this->middleware('api_permission:collection-request-list|collection-request-create|collection-request-edit|collection-request-delete', ['only' => ['index', 'store']]);
        $this->middleware('api_permission:collection-request-create', ['only' => ['create', 'store']]);

        $this->middleware('api_permission:manage-request-list|manage-request-create|manage-request-edit|manage-request-delete', ['only' => ['getManageRequestList', 'store']]);
        $this->middleware('api_permission:manage-request-edit', ['only' => ['edit', 'update']]);
        $this->middleware('api_permission:manage-request-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $data = $this->collectionRequestRepository->getAllRequest();
            $list = [];
            if (count($data) > 0) {
                if (!Request::input("all")) {
                    $list = [
                        "next_page" => $data->nextPageUrl(),
                        "previous_page" => $data->previousPageUrl(),
                        "total_page" => $data->lastPage(),
                        "total_records" => $data->total(),
                        "current_records" => $data->count()
                    ];
                }
                foreach ($data as $key => $item) {
                    $list["records"][$key] = $this->list($item);
                }
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => count($data) > 0 ? "Collection request list " : "No request found",
                "data" => $list
            ],
            count($data) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }

    public function getManageRequestList()
    {
        try {
            $data = $this->collectionRequestRepository->getAllManageRequest();
            $list = [];
            if (count($data) > 0) {
                if (!Request::input("all")) {
                    $list = [
                        "next_page" => $data->nextPageUrl(),
                        "previous_page" => $data->previousPageUrl(),
                        "total_page" => $data->lastPage(),
                        "total_records" => $data->total(),
                        "current_records" => $data->count()
                    ];
                }
                foreach ($data as $key => $item) {
                    $list["records"][$key] = $this->list($item);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => count($data) > 0 ? "Collection Manage request list " : "No request found",
                "data" => $list
            ],
            count($data) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFurnitureCollection $request)
    {
        try {
            $data = $this->collectionRequestRepository->AddCollectionRequest($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => $data ? "Your Furniture Collection Request has been submitted successfully! " : "internal server error , Please try again !",
                "data" => $data ? $this->list($data) : $data
            ],
            $data ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFurnitureCollection $request, $id)
    {
        $collect = CollectionRequest::find($id);
        if (!$collect) {
            return response()->json(["message" => "Collection request not found", "data" => ""], Response::HTTP_NOT_FOUND);
        }

        try {
            $data = $this->collectionRequestRepository->EditCollectionRequest($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => $data ? "The changes have been updated successfully !" : "Collection request can not be updated !",
                "data" => $data ? $this->list($data) : ""
            ],
            $data ? Response::HTTP_OK : Response::HTTP_FORBIDDEN
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collect =  CollectionRequest::find($id);
        if (!$collect) {
            return response()->json(["message" => "Collection request not found", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->collectionRequestRepository->deleteCollectionRequest($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => $data ? "The changes have been deleted successfully !" : "Collection request can not be deleted !",
                "data" => $data
            ],
            $data ? Response::HTTP_OK : Response::HTTP_FORBIDDEN
        );
    }

    public function searchRequest(CollectionRequestSearch $request)
    {

        try {
            $data = $this->searchRepository->searchRequest($request);
            $list = [];
            if (count($data)) {
                if (!Request::input("all")) {
                    $list = [
                        "next_page" => $data->nextPageUrl(),
                        "previous_page" => $data->previousPageUrl(),
                    ];
                }
                foreach ($data as $key => $item) {
                    $list['records'][$key] = $this->list($item);
                }
                return response()->json(["message" => "Collection request list", "data" => $list], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => "Your search did not match any records.", "data" => []], Response::HTTP_NOT_FOUND);
    }

    public function searchManageRequest(CollectionRequestSearch $request)
    {

        try {
            request()->status_id = RequestStatus::COLLECTION_PENDING;
            $data = $this->searchRepository->searchRequest($request);
            $list = [];
            if (count($data)) {
                if (!Request::input("all")) {
                    $list = [
                        "next_page" => $data->nextPageUrl(),
                        "previous_page" => $data->previousPageUrl(),
                    ];
                }
                foreach ($data as $key => $item) {
                    $list["records"][$key] = $this->list($item);
                }
                return response()->json(["message" => "Collection request list", "data" => $list], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => "Your search did not match any records.", "data" => []], Response::HTTP_NOT_FOUND);
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
                'replenished_count' =>  $value->replenished_count,
                'approved_replenished_count' =>  $value->approved_replenished_count,
                'rejected_replenished_count' =>  $value->rejected_replenished_count,
                'delivered_count' => $value->delivered_count,
                'item_full_count' => $value->item_full_count
            ];
        }
        return $list;
    }
}
