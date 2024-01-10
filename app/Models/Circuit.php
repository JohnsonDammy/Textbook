<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\CMC;
use App\Models\Subplace;

class Circuit extends Model
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    use HasFactory, Loggable, SoftDeletes;
    protected $table = "circuits";

    protected $fillable = [
        'circuit_name',
        'cmc_id'
    ];

    public function getCmcDetails()
    {
        return $this->belongsTo(CMC::class,'cmc_id');
    }
    public function getSubplaceDetails()
    {
        return $this->hasMany(Subplace::class,'circuit_id');
    }
}
