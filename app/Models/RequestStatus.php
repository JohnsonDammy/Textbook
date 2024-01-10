<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;
    protected $fillable=["name"];

    public const COLLECTION_PENDING = 1;
    public const COLLECTION_ACCEPTED = 2;
    public const REPAIR_PENDING = 3;
    public const REPAIR_COMPLETED = 4;
    public const DELIVERY_PENDING = 5;
    public const DELIVERY_CONFIRMED = 6;
}
