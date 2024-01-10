<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationaryModelCatalogue extends Model
{
 use HasFactory;

 //INSERT INTO `stationarycatgories`(`Id`, `ITEM CODE`, `ITEM`, `PRICE`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')

 //INSERT INTO `stationarycat`(`id`, `ItemCode`, `Item`, `Quantity`, `UnitPrices`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')

     protected $table = 'stationarycat'; // Specify the table name if it's different from the model name
     protected $fillable = ['id', 'ItemCode', 'Item', 'Quantity', 'UnitPrices'];


}
