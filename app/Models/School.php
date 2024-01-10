<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SchoolDistrict;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\CMC;
use App\Models\Circuit;
use App\Models\Subplace;
use App\Models\SchoolSnq;
use App\Models\SchoolLevel;

class School extends Model
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection


    use HasFactory, Loggable, SoftDeletes;
    protected $table = "schools";

    protected $fillable = [
        'name',
        'emis',
        'district_id',
        'cmc_id',
        'circuit_id',
        'subplace_id',
        'snq_id',
        'level_id',
        'school_principal',
        'tel',
        'street_code',
    ];

    public function getDistrict()
    {
        return $this->belongsTo(SchoolDistrict::class, 'district_id');
    }
    public function getCMC()
    {
        return $this->belongsTo(CMC::class, 'cmc_id');
    }

    public function getCMCbyDistrict($id)
    {
        // return $this->hasMany(CMC::class, 'district_id');
        return CMC::where('district_id', '=', $id)->get();
    }

    public function getCircuit()
    {
        return $this->belongsTo(Circuit::class, 'circuit_id');
    }

    public function getCircuitbyCMC($id)
    {
        // return $this->hasMany(Circuit::class, 'cmc_id');
        return Circuit::where('cmc_id', '=', $id)->get();
    }

    public function getSubplace()
    {
        return $this->belongsTo(Subplace::class, 'subplace_id');
    }

    public function getSubplacebyCircuit($id)
    {
        // return $this->hasMany(Subplace::class, 'circuit_id');
        return Subplace::where('circuit_id', '=', $id)->get();
    }

    public function getSNQDetails()
    {
        return $this->belongsTo(SchoolSnq::class, 'snq_id');
    }
    
    public function getLevelDetails()
    {
        return $this->belongsTo(SchoolLevel::class, 'level_id');
    }

    public function getAddress()
    {
        $list = [
            "district" => $this->getDistrict(),
            "cmc" => $this->getCMC(),
            "circuit" => $this->getCircuit(),
            "subplace" => $this->getSubplace()
        ];
        return $list;
    }
}
