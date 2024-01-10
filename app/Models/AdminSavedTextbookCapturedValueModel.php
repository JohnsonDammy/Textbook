<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSavedTextbookCapturedValueModel extends Model
{
    //INSERT INTO `adminsavedtextbookcapturedvalue`(`Id`, `Emis`, `ISBN`, `Grade`, `Title`, `Publisher`, `Subject`, `Price`, `Quantity`, `Captured_Quantity`, `RequestType`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')
    use HasFactory;

    protected $table = 'adminsavedtextbookcapturedvalue'; // Specify the table name if it's different from the model name
    protected $fillable = ['Emis', 'ISBN', 'Grade', 'Title', 'Publisher', 'Subject', 'Price', 'Quantity', 'Captured_Quantity', 'RequestType', 'textbook_id', 'refNoSeq'];
}
