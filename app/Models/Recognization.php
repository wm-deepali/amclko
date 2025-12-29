<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recognization extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status'
    ];
}
