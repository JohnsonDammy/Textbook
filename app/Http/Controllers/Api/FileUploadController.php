<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FurnitureCollection\StoreDeliverCollectionRequest;
use App\Http\Requests\UploadDisposalImagesRequest;
use App\Http\Requests\UploadProofOfReplenishmentRequest;
use App\Interfaces\FileUploadRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\RequestStatus;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends Controller
{
    // accessing File Upload repository from Repository Folder
    private FileUploadRepositoryInterface $fileRepo;

    function __construct(FileUploadRepositoryInterface $fileRepo)
    {
        $this->fileRepo = $fileRepo;
    }

    /*
     * Function for Upload Proof of Replinishment 
     * Storing files and updating table fields accordingly
     */

    public function proofOfReplenishment(UploadProofOfReplenishmentRequest $request)
    {
        try {
            //calling function from repository
            $data = $this->fileRepo->uploadProofOfReplineshment($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($data) {
            return response()->json(["message" => " Proof of Replenishment Decision has been saved successfully!", "data" => $this->list($data)], Response::HTTP_OK);
        }
        return response()->json(["message" => "Invalid request ", "data" => ""], Response::HTTP_NOT_FOUND);
    }


    public function disposalImages(UploadDisposalImagesRequest $request)
    {
        try {
            //calling function from repository
            $data = $this->fileRepo->uploadProofOfDisposal($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($data) {
            return response()->json(["message" => " Disposal Evidence proof has been saved successfully!", "data" => $this->list($data)], Response::HTTP_OK);
        }
        return response()->json(["message" => "Invalid request ", "data" => ""], Response::HTTP_NOT_FOUND);
    }

    /*
     * Function for Upload proof of delivery 
     * Storing files and updating table fields accordingly
     * Updating request status to Delivery confirmed
     */

    public function submitCollectionDelivery(StoreDeliverCollectionRequest $request)
    {
        try {
            //calling function from repository
            $data = $this->fileRepo->submitCollectionDelivery($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($data) {
            return response()->json(["message" => " Proof of Replenishment Decision has been saved successfully!", "data" => $this->list($data)], Response::HTTP_OK);
        }
        return response()->json(["message" => "Invalid request ", "data" => ""], Response::HTTP_NOT_FOUND);
    }

    //    common list for generating Request deatils
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
            "replenish_proof" => $collection->getUploadReplenishmentProof ? asset(Storage::url($collection->getUploadReplenishmentProof->path)) : null,
            "request_signed_note" =>  $collection->getUploadDeliveryNote ? asset(Storage::url($collection->getUploadDeliveryNote->path)) : null,
            "broken_items" => $this->brokenItemList($brokenItems)
        ];
    }

    // broken items list for access broken items realated to request
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
            ];
        }
        return $list;
    }
}
