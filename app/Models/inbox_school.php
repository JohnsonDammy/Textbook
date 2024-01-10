<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class inbox_school extends Model
{


    use HasFactory;
    protected $table = "inbox_school";

  
    protected $fillable=['Id','requestType', 'allocation','status', 'activity_name','funds_request_id'];

    //get user details organization wise , defining relations
}
