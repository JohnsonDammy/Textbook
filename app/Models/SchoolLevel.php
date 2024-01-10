<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\School;

class SchoolLevel extends Model
{
    use HasFactory;
    protected $fillable = ["name"];

    public function getSchools()
    {
        return $this->hasMany(School::class, 'level_id');
    }
}
