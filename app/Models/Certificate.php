<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'image',
        'status'
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
            'certificates/',
            'certificates/thumb/',
            $this->image
        );
    }
}
