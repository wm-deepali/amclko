<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnualReport extends Model
{
    protected $fillable = [
        'title',
        'pdf',
        'status',
    ];

    public function getPdfUrlAttribute()
    {
        return asset('storage/'.$this->pdf);
    }
}
