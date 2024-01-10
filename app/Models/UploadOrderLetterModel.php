<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadOrderLetterModel extends Model
{
    use HasFactory;

    //INSERT INTO `submitorderedform`(`Id`, `Emis`, `SupplierID`, `RequestType`, `SignedOrderedUploadForm`, `DeliveryDate`, `FailDate`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')


    protected $table = 'submitorderedform'; // Specify the table name if it's different from the model name

    protected $fillable = ['Id', 'Emis', 'SupplierID', 'RequestType', 'SignedOrderedUploadForm', 'DeliveryDate',  'FailDate', 'Date'];
}
