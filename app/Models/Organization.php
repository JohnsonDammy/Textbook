<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Organization extends Model
{
    protected $connection = 'itrfurns';

    use HasFactory;
    protected $table = "organizations";

    protected $casts = [
        'permissions' => 'array'
    ];
    protected $fillable=['name','permissions'];

    //get user details organization wise , defining relations
    public function getUsers()
    {
        return $this->hasMany(User::class,'organization');
    }
}
