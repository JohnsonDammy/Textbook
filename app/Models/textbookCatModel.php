<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class textbookCatModel extends Model
{
    use HasFactory;

    protected $table = 'textbookcat'; // Specify the table name if it's different from the model name
    protected $fillable = ['id', 'CatType', 'Grade', 'Subject', 'Language' , 'Language_Level', 'Publisher', 'ISBN', 'Component', 'Price' ];
}