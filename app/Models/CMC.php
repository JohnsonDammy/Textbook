<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\Circuit;
use App\Models\SchoolDistrict;

class   CMC extends Model
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    use HasFactory, Loggable, SoftDeletes;
    protected $table = "c_m_c_s";

    protected $fillable = [
        'cmc_name',
        'district_id'
    ];

    public function getDistrictDetails()
    {
        return $this->belongsTo(SchoolDistrict::class, 'district_id');
    }

    public function getCircuitDetails()
    {
        return $this->hasMany(Circuit::class, 'cmc_id');
    }
}
