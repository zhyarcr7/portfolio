<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Work extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'category',
        'featured',
        'technologies'
    ];

    protected $casts = [
        'featured' => 'boolean'
    ];
    
    /**
     * Get URL for the image
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            return Storage::url($this->image);
        }
        
        return null;
    }
    
    /**
     * Get URL for the thumbnail
     *
     * @return string|null
     */
    public function getThumbnailUrlAttribute()
    {
        if (empty($this->image)) {
            return null;
        }
        
        $thumbnailPath = 'works/thumbnails/' . basename($this->image);
        if (Storage::disk('public')->exists($thumbnailPath)) {
            return Storage::url($thumbnailPath);
        } 
        
        // Fallback to the original image if thumbnail doesn't exist
        return $this->image_url;
    }
}
