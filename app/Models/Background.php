<?php

// app/Models/Background.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status'
    ];
}
