<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use Illuminate\Database\Seeder;

class ContactInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First remove any existing records
        ContactInformation::truncate();
        
        // Create a default contact information
        ContactInformation::create([
            'address' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'postal_code' => '10001',
            'country' => 'United States',
            'map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.3059445135!2d-74.25986613799748!3d40.69714941954754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sca!4v1612364953709!5m2!1sen!2sca',
            'email' => 'contact@example.com',
            'phone' => '+1 (555) 123-4567',
            'website' => 'https://example.com',
            'facebook' => 'https://facebook.com/yourusername',
            'twitter' => 'https://twitter.com/yourusername',
            'instagram' => 'https://instagram.com/yourusername',
            'linkedin' => 'https://linkedin.com/in/yourusername',
            'whatsapp' => '+15551234567',
            'opening_hours' => "Monday - Friday: 9am - 5pm\nSaturday: 10am - 2pm\nSunday: Closed",
            'is_active' => true
        ]);
    }
} 