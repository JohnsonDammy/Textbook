<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLetterModel extends Model
{
    use HasFactory;
    //INSERT INTO `orderform`(`Id`, `EMIS`, `RequestType`, `FileName`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    protected $table = "orderform";
    protected $fillable=['Id','EMIS', 'RequestType','FileName', 'Date', 'DeliveryDate', 'FailDate'];
}
