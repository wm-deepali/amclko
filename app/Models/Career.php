<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'post_applied',
        'qualification',
        'message',
        'resume',
    ];
}
