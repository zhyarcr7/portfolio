<?php

namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic navigation items
        $items = [
            [
                'name' => 'Home',
                'url' => '/',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Works',
                'url' => '#works',
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Blogs',
                'url' => '#blogs',
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Testimonials',
                'url' => '#testimonials',
                'order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'About',
                'url' => '#about',
                'order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Contact',
                'url' => '#contact',
                'order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Zhyar CV',
                'url' => '#zhyarcv',
                'order' => 7,
                'is_active' => true
            ]
        ];

        foreach ($items as $item) {
            Navigation::create($item);
        }
    }
}
