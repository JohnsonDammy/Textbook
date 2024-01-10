<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliyerModel extends Model
{
    use HasFactory;
    //INSERT INTO `suppliyer`(`Id`, `email`, `CompanyName`, `CompanyAddress`, `CompanyContact`, `ISActive`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
        protected $table = 'suppliyer'; // Specify the table name if it's different from the model name

        protected $fillable = ['Id', 'email', 'CompanyName', 'CompanyAddress', 'CompanyContact', 'ISActive'];
    }
