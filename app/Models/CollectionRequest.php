<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\BrokenItem;
use App\Models\RequestStatus;
use App\Models\User;
use App\Models\School;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UploadReplenishmentProof;
use App\Models\UploadDeliveryNote;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionRequest extends Model
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection


    use HasFactory, Loggable, SoftDeletes;
    protected $fillable = [
        "ref_number", "user_id", "school_name", "emis", "total_broken_items", "total_furniture", "status_id",
        "accepted_at", "collected_at", "repaired_at", "delivered_at", "replenishment_status", "district_id",
        "district_name"
    ];

    public function getBrokenItems()
    {
        return $this->hasMany(BrokenItem::class, "collect_req_id");
    }

    public function getRequestImages()
    {
        return $this->hasMany(CollectionRequestImage::class, "collect_req_id");
    }

    public function getDisplosalImages()
    {
        return $this->hasMany(DisposalProofImages::class, 'collect_req_id');
    }

    public function getRequestStatus()
    {
        return $this->belongsTo(RequestStatus::class, "status_id");
    }

    public function getReplenishStatus()
    {
        return $this->belongsTo(ReplenishmentStatus::class, "replenishment_status");
    }

    public function getUserDetails()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function getUploadReplenishmentProof()
    {
        return  $this->hasOne(UploadReplenishmentProof::class, 'collect_req_id');
    }
    public function getUploadDeliveryNote()
    {
        return  $this->hasOne(UploadDeliveryNote::class, 'collect_req_id');
    }

    public function getSchoolDetails($emis)
    {
        return School::where('emis', '=', $emis)->first();
    }

    public function getDistrict()
    {
        return $this->belongsTo(SchoolDistrict::class, 'district_id');
    }
}
