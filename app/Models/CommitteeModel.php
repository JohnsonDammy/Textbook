<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeModel extends Model
{
    use HasFactory;

    //INSERT INTO `committee_member`(`Id`, `School_Emis`, `District_Id`, `Name`, `Designation`, `Contact_No`, `Signature`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')

    protected $table = 'committee_member'; // Specify the table name if it's different from the model name

    protected $fillable = ['Id', 'School_Emis', 'District_Id', 'Name', 'Designation', 'Contact_No', 'Signature', 'Date'];
}
