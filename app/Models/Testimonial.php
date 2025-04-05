<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'position',
        'company',
        'feedback',
        'image',
        'rating'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];
}
