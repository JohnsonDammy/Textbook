<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    use HasFactory;

    protected $table = 'lookup';
    protected $primaryKey = 'id';
    public $timestamps = false; // Assuming there are no timestamp columns in the table

    protected $fillable = [
        'Designation',
    ];

}
