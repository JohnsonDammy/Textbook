<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ef48docs extends Model
{
    use HasFactory;
    //INSERT INTO `doc_quote`(`id`, `Emis`, `FileName`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
        // INSERT INTO `ef48docs`(`id`, `file_Unsigned`, `school_emis`, `requestType`, `file_Signed`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')

    protected $table = 'ef48docs'; // Specify the table name if it's different from the model name
    protected $fillable = ['id',  'file_Signed', 'file_Unsigned', 'school_emis', 'requestType'];
}
