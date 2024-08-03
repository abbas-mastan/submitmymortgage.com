<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

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
        'role',
        'password_changed_at',
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
    public function trial()
    {
        return $this->hasOne(Trial::class);
    }
    public function userSubscriptionInfo()
    {
        return $this->hasOne(UserSubscriptionInfo::class);
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
    public function allCreatedApplications()
    {
        $applications = $this->applications;
        foreach ($this->createdUsers as $createdUser) {
            $applications = $applications->merge($createdUser->allCreatedApplications());
        }
        return $applications;
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
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function intakes()       
    {
        return $this->hasMany(IntakeForm::class,'created_by');
    }
    
    public function subscriptionDetails()       
    {
        return $this->hasOne(SubscriptionDetails::class);
    }
    public function cardDetails()       
    {
        return $this->hasOne(CardDetails::class,'user_id');
    }

    public function customQuote() 
    {
        return $this->hasOne(CustomQuote::class);
    }

    public function training() 
    {
        return $this->hasOne(UserTraining::class);
    }

    public function payments() 
    {
        return $this->hasMany(PaymentDetail::class);
    }

    public function personalInfo()
    {
        return $this->hasOne(UserPersonalInfo::class,'user_id');
    }

   
    public function metas()
    {
        return $this->hasMany(UserMeta::class);
    }
}