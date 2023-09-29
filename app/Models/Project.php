<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function setManagersAttribute($value)
    {
        // Convert the array to JSON format
        $this->attributes['managers'] = json_encode($value);
    }

    // Define an accessor to convert the JSON back to an array when accessing the 'managers' attribute
    public function getManagersAttribute($value)
    {
        return json_decode($value, true);
    }
}
