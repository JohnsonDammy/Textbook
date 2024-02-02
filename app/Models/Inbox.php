<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{

    use HasFactory;
    // INSERT INTO `inbox`(`Id`, `RequestFundsId`, `School_Emis`, `References_Number`, `District_Id`, `SchoolName`, `RequestType`, `Request`, `Message`, `Date`, `year`, `seen`, `DelVal`, `DateTime`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]')
    protected $table = 'inbox'; // Specify the table name if it's different from the model name
    protected $fillable = ['Id', 'RequestFundsId', 'School_Emis', 'References_Number', 'SchoolName', 'District_Id', 'RequestType', 'Message', 'Date', 'year', 'Request', 'seen', 'DelVal', 'DateTime'];

}
