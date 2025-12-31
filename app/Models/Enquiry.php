<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'country_code',
        'mobile',
        'location',
        'details',
        'ip_address',
    ];
}
