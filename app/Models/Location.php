<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';

    protected $fillable = [
        'address',
        'map_url',
        'contact_email',
        'phone'
    ];
}
