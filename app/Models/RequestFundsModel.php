<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFundsModel extends Model
{

    // INSERT INTO `fundsrequest`(`id`, `References_Number`, `School_Emis`, `School_Name`, `FundsAmount`, `RequestType`, `Status`, `Action_By`, `Message`, `year`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')

    use HasFactory;

    protected $table = 'fundsrequest'; // Specify the table name if it's different from the model name
    protected $fillable = ['id','References_Number', 'School_Emis', 'School_Name', 'amount_stationery' ,'ApprovedAmountTextbook', 'ApprovedAmountStationery', 'amount_textbook', 'RequestType', 'Status', 'Date', 'Action_By', 'Message', 'year', 'date','circular_id', 'comment'];



    public function document()
{
    return $this->belongsTo(Document::class, 'circular_id');
}
}


