<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\School;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\CMC;

class SchoolDistrict extends Model
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection


    use HasFactory, Loggable, SoftDeletes;
    protected $table = "school_districts";

    protected $fillable = [
        'district_office'
    ];

    public function getSchool()
    {
        return $this->hasMany(School::class);
    }

    public function getCMCDetails()
    {
        return $this->hasMany(CMC::class, 'district_id');
    }

    public function getRequests()
    {
        return $this->hasMany(CollectionRequest::class, 'district_id');
    }
}
