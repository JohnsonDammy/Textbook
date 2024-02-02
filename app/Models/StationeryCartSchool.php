<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationeryCartSchool extends Model
{
    use HasFactory;

    protected $table = 'stationerycartSchool';

    //INSERT INTO `stationerycartschool`(`id`, `emis`, `ItemCode`, `item`, `updated_at`, `.created_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
    protected $fillable = [
        'ItemCode',
        'emis',
        'item',
        'updated_at',
        'created_at',
    ];
}
