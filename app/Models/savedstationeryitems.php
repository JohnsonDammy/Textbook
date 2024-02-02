<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class savedstationeryitems extends Model
{
    use HasFactory;
    //INSERT INTO `savedstationeryitems`(`id`, `item_code`, `item_title`, `price`, `Quantity`, `TotalPrice`, `inbox_id`, `stationery_id`, `school_emis`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')

    protected $table = 'savedstationeryitems'; // Specify the table name if it's different from the model name
    protected $fillable = ['id' , 'item_code', 'item_title', 'price', 'Quantity', 'TotalPrice', 'inbox_id', 'stationery_id', 'school_emis'];
}
