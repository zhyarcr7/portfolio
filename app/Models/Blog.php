<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'is_published',
        'category',
        'summary',
        'featured',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'featured' => 'boolean',
    ];
}
