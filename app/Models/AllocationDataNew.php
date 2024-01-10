<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationDataNew extends Model
{

    protected $connection = 'itrfurns'; // Specify the desired database connection

    use HasFactory;
//INSERT INTO `allocationfunds`(`Id`, `EMIS`, `TEXTBOOK ALLOCATION`, `STATIONERY ALLOCATION`, `OTHER LTSM`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    protected $table = 'alloctionfunddata'; // Specify the table name if it's different from the model name
    protected $fillable = ['Id', 'Description', 'file'];
}
