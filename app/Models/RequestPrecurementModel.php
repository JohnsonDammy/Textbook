<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPrecurementModel extends Model
{
    use HasFactory;

   
    protected $table = 'procurementselection'; // Specify the table name if it's different from the model name
    protected $fillable = ['Textbook', 'Stationary', 'NoDeclaration', 'school_emis', 'year', 'SchoolName', 'Date', 'ActionBy','circular_id'];
}

?>