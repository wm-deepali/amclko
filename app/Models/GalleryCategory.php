<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    protected $fillable = [
        'title',
        'include_in_programmes',
        'status'
    ];

    protected $casts = [
        'include_in_programmes' => 'boolean',
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }

    public function programmes()
    {
        return $this->belongsToMany(
            Program::class,
            'gallery_category_program'
        );
    }
    
}
