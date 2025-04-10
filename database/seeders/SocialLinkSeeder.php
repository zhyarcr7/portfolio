<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove existing links
        SocialLink::truncate();
        
        // Create default social links
        $socialLinks = [
            [
                'platform' => 'LinkedIn',
                'url' => 'https://www.linkedin.com/in/your-profile',
                'icon_class' => 'fab fa-linkedin-in',
                'order' => 1,
                'is_active' => true
            ],
            [
                'platform' => 'GitHub',
                'url' => 'https://github.com/your-username',
                'icon_class' => 'fab fa-github',
                'order' => 2,
                'is_active' => true
            ],
            [
                'platform' => 'Twitter',
                'url' => 'https://twitter.com/your-username',
                'icon_class' => 'fab fa-twitter',
                'order' => 3,
                'is_active' => true
            ],
            [
                'platform' => 'Instagram',
                'url' => 'https://www.instagram.com/your-username',
                'icon_class' => 'fab fa-instagram',
                'order' => 4,
                'is_active' => true
            ]
        ];
        
        foreach ($socialLinks as $link) {
            SocialLink::create($link);
        }
    }
} 