<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deliveryselection extends Model
{
    use HasFactory;

    //INSERT INTO `deliveryselection`(`Id`, `Emis`, `References_Number`, `District_Id`, `SupplierID`, `FilePath`, `RecievedQuantity`, `RequestType`, `date`, `IsActive`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
    protected $table = 'deliveryselection'; // Specify the table name if it's different from the model name

    protected $fillable = ['Id', 'Emis', 'References_Number', 'District_Id', 'SupplierID', 'FilePath', 'RecievedQuantity', 'RequestType', 'date', 'IsActive'];
}
