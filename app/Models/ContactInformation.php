<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'map_url',
        'email',
        'phone',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'whatsapp',
        'opening_hours',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the formatted full address.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $parts = [];
        
        if (!empty($this->address)) {
            $parts[] = $this->address;
        }
        
        $cityParts = [];
        if (!empty($this->city)) {
            $cityParts[] = $this->city;
        }
        
        if (!empty($this->state)) {
            $cityParts[] = $this->state;
        }
        
        if (!empty($this->postal_code)) {
            $cityParts[] = $this->postal_code;
        }
        
        if (!empty($cityParts)) {
            $parts[] = implode(', ', $cityParts);
        }
        
        if (!empty($this->country)) {
            $parts[] = $this->country;
        }
        
        return implode(', ', $parts);
    }
}
