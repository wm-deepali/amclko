<?php

// app/Models/UrduAcademy.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrduAcademy extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status',
    ];

    // ✅ Auto-append this attribute
    protected $appends = ['thumb_image'];

    /**
     * Get thumbnail image URL
     */
    public function getThumbImageAttribute()
    {
        if (!$this->image) {
            return null;
        }
        return str_replace(
            'affiliation/',
            'affiliation/thumb/',
            $this->image
        );
    }
}
