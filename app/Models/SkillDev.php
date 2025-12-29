<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillDev extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status',
    ];
}
