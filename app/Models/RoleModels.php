<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModels extends Model
{
    //INSERT INTO `organizations`(`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')

    use HasFactory;

    protected $table = 'organizations'; // Specify the table name if it's different from the model name
    protected $fillable = ['id', 'name', 'permissions', 'created_at', 'updated_at'];



    use HasFactory;
}
