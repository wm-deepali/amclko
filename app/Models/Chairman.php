<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chairman extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status'
    ];
}
