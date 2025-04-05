<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    // Use the table created by our migration
    protected $table = 'hero_slides';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'bgImage',
        'ctaText',
        'ctaLink',
        'secondaryCtaText',
        'secondaryCtaLink',
        'highlightedText',
        'button_text',
        'button_link',
        'order',
        'is_active',
        
        // Fields for the new table schema
        'image_path',
    ];
    
    // Method to use the new table format if needed
    public function useNewTable()
    {
        $this->table = 'hero_slides';
        return $this;
    }
    
    // Method to use the old table format if needed (for backward compatibility)
    public function useOldTable()
    {
        $this->table = 'heroslides';
        return $this;
    }
}
