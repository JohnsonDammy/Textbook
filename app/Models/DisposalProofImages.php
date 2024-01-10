<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class DisposalProofImages extends Model
{
    use HasFactory, Loggable;
    protected $fillable = ["collect_req_id", "image_path"];

    public function getCollectionRequestDetails(){
        return $this->belongsTo(CollectionRequest::class,"collect_req_id");
    }
}
