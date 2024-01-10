<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class savedSuppliers  extends Model
{
    use HasFactory;
    //INSERT INTO `doc_quote`(`id`, `Emis`, `FileName`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
    protected $table = 'savedsuppliers'; // Specify the table name if it's different from the model name
    protected $fillable = ['id', 'supplierID', 'emis', 'requestType' ];
}
