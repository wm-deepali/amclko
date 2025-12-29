<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $fillable = [
        'title',
        'image',
        'status'
    ];


    public function getThumbUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . str_replace('logos/', 'logos/thumb/', $this->image))
            : null;
    }
}
