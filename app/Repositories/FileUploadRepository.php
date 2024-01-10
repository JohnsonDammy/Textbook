<?php

namespace App\Repositories;

use App\Interfaces\FileUploadRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\ReplenishmentStatus;
use App\Models\RequestStatus;
use App\Models\UploadDeliveryNote;
use App\Models\UploadReplenishmentProof;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DisposalProofImages;


class FileUploadRepository implements FileUploadRepositoryInterface
{
    /*
     * Function for Upload Proof of Replinishment 
     * Storing files and updating table fields accordingly
     */
    public function uploadProofOfDisposal(object $request)
    {
        $flag = false;
        DB::beginTransaction();
        try {
            $collection = CollectionRequest::where('ref_number', $request->ref_number)->first();
            if (!$collection) {
                return null;
            }
            //$image = $request->file('disposal_images');
            $req_number = $request->ref_number;
            $id = $collection->id;
            $count = 1;
            if ($request->disposal_images) {
                if (count($request->disposal_images) > 0) {
                    $tmp_img_path = [];
                    foreach ($request->file('disposal_images') as $img) {
                        $img_name = $req_number . '_img_' . $count . '.' . $img->extension();
                        $path = Storage::putFileAs('public/disposal_images', $img, $img_name);
                        $image = DisposalProofImages::create([
                            'collect_req_id' => $id,
                            'image_path' => $path
                        ]);
                        // $img->move(public_path('uploads/images'), $img_name);
                        $count++;
                        array_push($tmp_img_path, $path);
                    }
                }
            }
            $flag = true;
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $count = 1;
            if ($flag) {
                Storage::delete($tmp_img_path);
            }
            $collection = null;
            throw $th;
        }
        return $collection;
    }

    /*
     * Function for Upload Proof of Replinishment 
     * Storing files and updating table fields accordingly
     */
    public function uploadProofOfReplineshment(object $request)
    {
        $flag = false;
        DB::beginTransaction();
        try {
            $collection = CollectionRequest::where('ref_number', $request->ref_number)->first();
            if (!$collection) {
                return null;
            }
            $image = $request->file('upload_proof');
            $img_name = $collection->ref_number . '_proof_of_replenishment_' . date('YmdHis') . '.' . $image->extension();
            $path =   Storage::putFileAs("public/replenishment_proof", $image, $img_name);
            $flag = true;

            //check for existing record.
            $proofrecord = UploadReplenishmentProof::where('collect_req_id',  $collection->id)->first();

            if (!$proofrecord) {
                $proof = UploadReplenishmentProof::create([
                    "collect_req_id" => $collection->id,
                    "path" => $path
                ]);
            } else {
                Storage::delete($proofrecord->path);
                $proofrecord->path = $path;
                $proofrecord->update();
            }
            $accepted_replenish_items = json_decode($request->accept_array, true);
            foreach ($accepted_replenish_items as $item) {
                $broken_item = BrokenItem::where('id', $item['id'])->first();
                // dd($broken_item);
                $broken_item->approved_replenished_count = $item['accept_count'];
                $broken_item->rejected_replenished_count = $item['reject_count'];
                $broken_item->delivered_count = $item['accept_count'] +  $broken_item->repaired_count ;
                $broken_item->update();
            }

            $collection->replenishment_status = ReplenishmentStatus::COMPLETE;
            $collection->update();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($flag) {
                Storage::delete($path);
            }
            $collection = null;
            throw $th;
        }
        return $collection;
    }

    /*
     * Function for Upload proof of delivery 
     * Storing files and updating table fields accordingly
     * Updating request status to Delivery confirmed
     */
    public function submitCollectionDelivery($request)
    {
        $flag = false;
        DB::beginTransaction();
        try {
            $collection = CollectionRequest::where('ref_number', $request->ref_number)->first();
            if (!$collection) {
                return null;
            }
            $image = $request->file('upload_file');
            $img_name = $collection->ref_number . '_img_' . date('YmdHis') . '.' . $image->extension();
            $path = Storage::putFileAs('public/signed_delivery', $image, $img_name);

            //flag to check whether file is uploaded or not . If not added then flag will be use in catch block
            $flag = true;
            $proof = UploadDeliveryNote::create([
                "collect_req_id" => $collection->id,
                "path" => $path
            ]);

            //Updating request status to Delivery confirmed
            $collection->status_id =  RequestStatus::DELIVERY_CONFIRMED;
            $collection->delivered_at =  Carbon::now()->toDateTimeString();
            $collection->update();
            DB::commit();
        } catch (\Throwable $th) {
            //deleting file if it is exist on server with the help of flag 
            if ($flag) {
                Storage::delete($path);
            }
            DB::rollBack();
            $collection = null;
            throw $th;
        }
        return $collection;
    }
}
