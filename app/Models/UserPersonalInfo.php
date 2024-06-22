<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalInfo extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false; // Disable automatic timestamps

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
