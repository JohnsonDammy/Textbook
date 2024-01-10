<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class savedtextbookitems extends Model
{
    use HasFactory;

    protected $table = 'savedtextbookitems'; // Specify the table name if it's different from the model name
    protected $fillable = ['Id,ISBN, Title, Price, Quantity, TotalPrice, inbox_id, textbook_id'];
}
