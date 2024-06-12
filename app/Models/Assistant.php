<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function borrower()
    {
        return $this->belongsTo(User::class);
    }
    public function assistant()
    {
        return $this->belongsTo(User::class,'assistant_id');
    }


}
