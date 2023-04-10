<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    //Get the owner of this media file
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Get the uploader of this media file
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, "uploaded_by");
    }
}
