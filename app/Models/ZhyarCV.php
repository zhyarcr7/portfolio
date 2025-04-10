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
        'professional_title',
        'content',
        'file_path',
        'skills',
        'education',
        'work_experience',
        'certifications',
        'is_active',
    ];
    
    protected $casts = [
        'skills' => 'array',
        'education' => 'array',
        'work_experience' => 'array',
        'certifications' => 'array',
        'is_active' => 'boolean',
    ];
}
