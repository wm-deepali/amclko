<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
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
            'sliders/',
            'sliders/thumb/',
            $this->image
        );
    }
}
