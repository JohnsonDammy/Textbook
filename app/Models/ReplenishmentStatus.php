<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplenishmentStatus extends Model
{
    use HasFactory;
    public const PENDING = 1;
    public const COMPLETE = 2;
   
    protected $fillable = ["name"];
    protected $table = "replenishment_statuses";
}
