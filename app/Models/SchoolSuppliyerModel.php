<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSuppliyerModel extends Model
{

    // INSERT INTO `school_suppliyer`(`Id`, `Suppliyer_id`, `Emis`, `email`, `CompanyName`, `CompanyAddress`, `CompanyContact`, `IsActive`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')    use HasFactory;
        protected $table = 'school_suppliyer'; // Specify the table name if it's different from the model name

        protected $fillable = ['Id', 'Suppliyer_id', 'Emis', 'email', 'CompanyName', 'CompanyAddress',  'CompanyContact', 'IsActive'];
    }
