<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deliveryCapture extends Model
{
    use HasFactory;

    //INSERT INTO `deliveryselection`(`Id`, `Emis`, `District_Id`, `SupplierID`, `FilePath`, `RecievedQuantity`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')

    protected $table = 'deliverycapture'; // Specify the table name if it's different from the model name

    protected $fillable = ['id', 'RefNoSeq', 'SeqNo', 'TotAmtCaptured', 'isFinal', 'TotalCaptureQuantityAmount'];
}
