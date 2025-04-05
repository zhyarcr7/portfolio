<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComingSoon extends Model
{
    protected $table = 'comingsoon';
    
    protected $fillable = [
        'title',
        'description',
        'launch_date',
        'is_active',
        'image',
        'button_text',
        'button_url'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'launch_date' => 'date'
    ];
}
