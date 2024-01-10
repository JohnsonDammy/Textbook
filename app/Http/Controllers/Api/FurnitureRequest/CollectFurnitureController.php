<?php

namespace App\Http\Controllers\Api\FurnitureRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\FurnitureCollection\StoreCollectionItems;
use App\Http\Requests\FurnitureCollection\StoreRepairCollectionRequest;
use App\Interfaces\FurnitureRequest\CollectFurnitureRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\RequestStatus;
use App\Interfaces\FurnitureRequest\RepairFurnitureRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class CollectFurnitureController extends Controller
{
    private CollectFurnitureRepositoryInterface $collectRepository;
    private RepairFurnitureRepositoryInterface $repairRepository;
    function __construct(CollectFurnitureRepositoryInterface $repository, RepairFurnitureRepositoryInterface $repairRepository)
    {
        $this->collectRepository = $repository;
        $this->repairRepository = $repairRepository;
        // $this->middleware('api_permission:collect-furniture-list|collect-furniture-create|collect-furniture-edit|collect-furniture-delete', ['only' => ['show','index']]);
        // $this->middleware('api_permission:collect-furniture-create', ['only' => ['edit', 'store']]);
        // $this->middleware('api_permission:collect-furniture-edit', ['only' => ['annexurea', 'annexureb', 'annexurecmail', 'uploadproof', 'submitrepair', 'annexured', 'submitdeliver']]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectionItems $request)
    {
        try {
            $collect = CollectionRequest::where('ref_number', $request->ref_number)->first();

            if ($collect->status_id != RequestStatus::COLLECTION_ACCEPTED) {
                return response()->json(["message" => $collect->status_id < RequestStatus::COLLECTION_ACCEPTED ? "Collection request is not accepted" : "Collection is already submitted for repairs"], Response::HTTP_FORBIDDEN);
            }
            $data = $this->collectRepository->addAcceptCollectFurnitureRequest($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => $data ? "The changes have been submitted successfully!" : "Collection request not found",
                "data" => $data ? $this->list($data) : null
            ],
            $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->collectRepository->getSingleCollectionRequest($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => $data ? "Collection request details" : "Collection not found with reference number : $id",
                "data" => $data ? $this->list($data) : $data
            ],
            $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //changing the status of collection request to PENDING COLLECTION
    public function edit($id)
    {
        $collect =  CollectionRequest::find($id);
        if (!$collect) {
            return response()->json(["message" => "Request already accepted or No request found!", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->collectRepository->acceptCollectFurniture($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => $data ? "The changes have been submitted successfully !" : "Status is already changed for this request !",
                "data" => $data ? $this->list($data) : ""
            ],
            $data ? Response::HTTP_OK : Response::HTTP_FORBIDDEN
        );
    }




    public function storeRepair(StoreRepairCollectionRequest $request)
    {
        try {
            $data = $this->repairRepository->storerepair($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(
            [
                "message" => $data ? "The changes have been submitted successfully!" : "Inernal server error",
                "data" => $data ? $this->list($data) : null
            ],
            $data ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR
        );
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
