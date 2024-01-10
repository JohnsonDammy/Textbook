<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stationeryCatModel extends Model
{
    use HasFactory;

    protected $table = 'stationarycat'; // Specify the table name if it's different from the model name
    protected $fillable = ['Id', 'ItemCode', 'Item', 'Quantity', 'UnitPrices' ];
}