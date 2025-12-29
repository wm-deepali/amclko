<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'url',
        'content',
        'image',
        'status',
    ];

    /* ===============================
     |  Accessors (optional but useful)
     =============================== */

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/'.$this->image)
            : null;
    }

    public function getThumbUrlAttribute()
    {
        return $this->image
            ? asset('storage/'.str_replace('courses/', 'courses/thumb/', $this->image))
            : null;
    }
}
