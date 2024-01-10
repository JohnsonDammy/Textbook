<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\CollectionRequest;
use App\Models\StockCategory;
use App\Models\StockItem;

class BrokenItem extends Model
{
    use HasFactory, Loggable;
    protected $table = "broken_items";
    protected $fillable = [
        "collect_req_id", "category_id", "item_id", "item_full_count", "old_count", "count", "confirmed_count",
        "repaired_count", "replenished_count", "delivered_count", "rejected_replenished_count", "approved_replenished_count"
    ];

    public function getCollectionDetails()
    {
        return $this->belongsTo(CollectionRequest::class, "collect_req_id");
    }

    public function getCategoryDetails()
    {
        return $this->belongsTo(StockCategory::class, "category_id");
    }
    public function getItemDetails()
    {
        return $this->belongsTo(StockItem::class, "item_id");
    }
}
