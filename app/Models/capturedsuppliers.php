<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class capturedsuppliers  extends Model
{
    use HasFactory;
    //INSERT INTO `doc_quote`(`id`, `Emis`, `FileName`, `Date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
    protected $table = 'capturedsuppliers'; // Specify the table name if it's different from the model name
    protected $fillable = ['id', 'quoteForm', 'sbd4Form', 'disclosureForm', 'taxClearanceForm', 'amount', 'comment' , 'taxClearance' , 'savedSupplierID'];
}