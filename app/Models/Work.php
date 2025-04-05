<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'title',
        'description',
        'images',
        'category',
        'featured',
        'technologies'
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean'
    ];
}
