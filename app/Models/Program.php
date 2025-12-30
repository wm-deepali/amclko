<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'detail_content',
        'thumbnail',
        'banner',
        'status',
    ];

    /* ================= ACCESSORS ================= */

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/no-image.png');
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner
            ? asset('storage/' . $this->banner)
            : asset('images/no-banner.png');
    }

    /* ================= SCOPES ================= */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    
    public function galleryCategories()
    {
        return $this->belongsToMany(
            \App\Models\GalleryCategory::class,
            'gallery_category_program'
        );
    }


}
