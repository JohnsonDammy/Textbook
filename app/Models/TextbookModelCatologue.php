<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class TextbookModelCatologue extends Model
{
   // protected $connection = 'itrfurns'; // Specify the desired database connection
    use HasFactory;
    //INSERT INTO `textbookcat`(`id`, `CatType`, `Grade`, `Subject`, `Language`, `Language_Level`, `Publisher`, `Title`, `ISBN`, `Component`, `Price`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')
        protected $table = 'textbookcat'; // Specify the table name if it's different from the model name
        protected $fillable = ['id', 'CatType', 'Grade', 'Header', 'Subject', 'Language', 'Language_Level', 'Publisher', 'Title', 'ISBN', 'Component', 'Price'];
}