<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
//INSERT INTO `indox`(`Id`, `School_Emis`, `District_Id`, `RequestType`, `Message`, `Date`, `year`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')

    use HasFactory;

    protected $table = 'inbox'; // Specify the table name if it's different from the model name
    protected $fillable = ['Id', 'School_Emis', 'District_Id', 'RequestType', 'Message', 'Date', 'year'];
}
