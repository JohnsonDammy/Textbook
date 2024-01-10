<?php

namespace App\Repositories\FurnitureRequest;

use App\Interfaces\FurnitureRequest\RepairFurnitureRepositoryInterface;
use App\Models\CollectionRequest;
use App\Models\BrokenItem;
use Illuminate\Support\Facades\DB;
use App\Models\RequestStatus;
use Carbon\Carbon;

class RepairFurnitureRepository implements RepairFurnitureRepositoryInterface
{
    public function storerepair(object $request)
    {
        DB::beginTransaction();
        try {
            $collect = CollectionRequest::where('ref_number', '=', $request->ref_number)->first();
            foreach ($request->items as $item) {
                $broken_item = BrokenItem::where('id', $item['id'])->first();
                $broken_item->replenished_count = $item['replenish_count'];
                $broken_item->repaired_count = $item['repair_count'];
                $broken_item->update();
            }
            $collect->status_id = RequestStatus::REPAIR_COMPLETED;
            $collect->repaired_at =  Carbon::now()->toDateTimeString();
            $collect->update();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            $collect = null;
        }
        return $collect;
    }
}
