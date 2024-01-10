<?php

namespace App\Repositories\FurnitureRequest;

use App\Interfaces\FurnitureRequest\CollectFurnitureRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\CollectionRequestImage;
use App\Models\UploadReplenishmentProof;
use App\Models\RequestStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CollectFurnitureRepository implements CollectFurnitureRepositoryInterface
{
    public function getSingleCollectionRequest($ref_no)
    {
        $data =  CollectionRequest::where('ref_number', '=', $ref_no)->first();
        if ($data) {
            $data->proofrecord = UploadReplenishmentProof::where('collect_req_id',  $data->id)->first();
        }
        return $data;
    }

    public function acceptCollectFurniture($id)
    {
        $collect = CollectionRequest::find($id);
        if (!$collect) {
            return null;
        }

        if ($collect->status_id == RequestStatus::COLLECTION_PENDING) {
            $collect->status_id = RequestStatus::COLLECTION_ACCEPTED;
            $collect->accepted_at =  Carbon::now()->toDateTimeString();
            $collect->update();
            return $collect;
        }
        return null;
    }

    public function addAcceptCollectFurnitureRequest($request)
    {
        $collect = CollectionRequest::where('ref_number', $request->ref_number)->first();
        if (!$collect) {
            return false;
        }
        $flag = false;
        DB::beginTransaction();
        try {
            foreach ($request->confirm_count as $item_id => $new_count) {
                $item = BrokenItem::find($item_id);
                $item->confirmed_count = $new_count;
                $item->update();
            }
            $req_number = $request->ref_number;
            $id = $collect->id;
            $count = 1;
            if ($request->images) {
                if (count($request->images) > 0) {
                    $tmp_img_path = [];
                    foreach ($request->file('images') as $img) {
                        $img_name = $req_number . '_img_' . $count . '.' . $img->extension();
                        $path = Storage::putFileAs('public/images', $img, $img_name);
                        $image = CollectionRequestImage::create([
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
            $collect->status_id = RequestStatus::REPAIR_PENDING;
            $collect->collected_at =  Carbon::now()->toDateTimeString();
            $collect->update();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $count = 1;
            if ($flag) {
                Storage::delete($tmp_img_path);
            }
            $collect = null;
            throw $th;
        }

        return $collect;
    }
}
