<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CollectionRequest;

class UploadReplenishmentProof extends Model
{
    use HasFactory;
    protected $fillable = ["collect_req_id", "path"];

    public function getCollectionDetails()
    {
        return $this->hasOne(CollectionRequest::class);
    }
}
