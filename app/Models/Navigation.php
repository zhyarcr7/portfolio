<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;
    
    protected $table = 'navigations';
    
    protected $fillable = [
        'name',
        'url',
        'icon',
        'order',
        'is_active',
        'target',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
    
    /**
     * Get the URL attribute.
     * Ensure # is correctly handled.
     */
    public function getUrlAttribute($value)
    {
        // If url is just '#', ensure it's not empty
        return $value === null || $value === '' ? '#' : $value;
    }
}
