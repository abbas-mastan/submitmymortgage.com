<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'accessToken'
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

    //Get all media files owned by this user
    public function media()
    {
        return $this->hasMany(Media::class);
    }
    //Get all media files uploaded by this user
    public function uploads()
    {
        return $this->hasMany(Media::class, "uploaded_by");
    } 
    //Get info of this user
    public function info()
    {
        return $this->hasOne(Info::class);
    } 
    public function getFirstName()
    {
        $names = explode(" ", $this->name);
        return !empty($names[0]) ? $names[0] : "";
    }
    public function getMiddleName()
    {
        $names = explode(" ", $this->name);
        if(count($names) > 1)
            return $names[1];
        return "";
    }
    public function getLastName()
    {
        $names = explode(" ", $this->name);
        if(count($names) > 1)
            return $names[2];
        return !empty($names[1]) ? $names[1] : "";
    }
}
