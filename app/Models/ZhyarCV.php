<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZhyarCV extends Model
{
    use HasFactory;
    
    protected $table = 'zhyar_c_v_s';
    
    protected $fillable = [
        'title',
        'content',
        'file_path',
        'skills',
        'education',
        'experience',
        'certifications',
        'is_active',
    ];
    
    protected $casts = [
        'skills' => 'array',
        'education' => 'array',
        'experience' => 'array',
        'certifications' => 'array',
        'is_active' => 'boolean',
    ];
}
