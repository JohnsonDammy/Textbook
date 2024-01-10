<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\Circuit;

class Subplace extends Model
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    use HasFactory, Loggable, SoftDeletes;
    protected $table = "subplaces";

    protected $fillable = [
        'subplace_name',
        'circuit_id'
    ];

    public function getCircuitDetails()
    {
        return $this->belongsTo(Circuit::class, 'circuit_id');
    }
}
