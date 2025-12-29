<?php

// app/Models/Secretary.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status'
    ];
}
