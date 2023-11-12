<?php

namespace App\Models;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'accessToken',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Get all media files owned by this user
    public function media()
    {
        return $this->hasMany(Media::class, 'user_id');
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
    public function infos()
    {
        return $this->hasMany(Info::class);
    }
    public function getFirstName()
    {
        $names = explode(" ", $this->name);
        return !empty($names[0]) ? $names[0] : "";
    }
    public function getMiddleName()
    {
        $names = explode(" ", $this->name);
        if (count($names) > 1) {
            return $names[1];
        }

        return "";
    }
    public function getLastName()
    {
        $names = explode(" ", $this->name);
        if (count($names) > 1) {
            return $names[2];
        }

        return !empty($names[1]) ? $names[1] : "";
    }
    public function categories()
    {
        return $this->hasMany(UserCategory::class, 'user_id');
    }
    public function application()
    {
        return $this->hasOne(Application::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }
    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function teamsOwnend()
    {
       return $this->hasMany(Team::class,'owner_id');
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function assistants()
    {
        return $this->hasMany(Assistant::class, 'user_id');
    }

    public function assistantCategories()
    {
        return $this->hasOne(Assistant::class, 'assistant_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'borrower_id');
    }
}
