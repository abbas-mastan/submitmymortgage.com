<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class,'company_id');
    }
    public function teams()
    {
        return $this->hasMany(Team::class,'company_id');
    }
}
