<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSavedStationeryCapturedValueModel extends Model
{
    use HasFactory;

    //INSERT INTO `adminsavedstationerycapturedvalue`(`id`, `ItemCode`, `Item`, `Quantity`, `UnitPrices`, `Captured_Quantity`, `updated_at`, `created_at`, `stationery_id`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')

    protected $table = 'adminsavedstationerycapturedvalue'; // Specify the table name if it's different from the model name
    protected $fillable = ['ItemCode', 'Emis', 'Item', 'Quantity', 'UnitPrices', 'Captured_Quantity', 'stationery_id'];


}
