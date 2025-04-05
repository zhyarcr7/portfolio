<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        HeroSlide::truncate();

        // Sample hero slides
        $slides = [
            [
                'title' => 'Welcome to My Portfolio',
                'subtitle' => 'Web Developer & Creative Designer',
                'description' => 'I create beautiful, responsive websites and applications with modern technologies.',
                'bgImage' => 'img/hero/slide1.jpg',
                'ctaText' => 'View Projects',
                'ctaLink' => '#works',
                'secondaryCtaText' => 'Contact Me',
                'secondaryCtaLink' => '#contact',
                'highlightedText' => 'Featured',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Creative Solutions',
                'subtitle' => 'Bringing Ideas to Life',
                'description' => 'From concept to completion, I deliver high-quality digital experiences.',
                'bgImage' => 'img/hero/slide2.jpg',
                'ctaText' => 'See My Work',
                'ctaLink' => '#works',
                'secondaryCtaText' => 'About Me',
                'secondaryCtaLink' => '#about',
                'highlightedText' => 'New',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Modern Web Development',
                'subtitle' => 'Laravel & React Expert',
                'description' => 'Building robust applications with cutting-edge technologies.',
                'bgImage' => 'img/hero/slide3.jpg',
                'ctaText' => 'Explore Services',
                'ctaLink' => '#services',
                'secondaryCtaText' => 'Read Blog',
                'secondaryCtaLink' => '#blog',
                'highlightedText' => 'Featured',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        // Insert slides
        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }
    }
}
