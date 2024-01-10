<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Organization;
use App\Models\CollectionRequest;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Notifications\ResetPasswordEmail as ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'organization',
        'status',
        'attempts',
        'email',
        'password',
        'District_Id',
        'system_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    //get organization details, defining relation

    public function getOrganization()
    {
        return $this->belongsTo(Organization::class, 'organization');
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getRequestDetails()
    {
        return $this->hasMany(CollectionRequest::class);
    }
}
