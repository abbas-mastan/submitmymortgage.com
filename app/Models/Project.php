<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $casts = [
        'managers' => 'array',
    ];

    public function borrower()
    {
        return $this->belongsTo(User::class,'borrower_id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class,'team_id');
    }

    public function creater()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    

}
