<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\HeroSlide;
use App\Models\Location;
use App\Models\Navigation;
use App\Models\Testimonial;
use App\Models\Work;
use App\Models\ZhyarCV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class WelcomeController extends Controller
{
    public function index()
    {
        try {
            // Check if the navigations table exists
            if (!\Schema::hasTable('navigations')) {
                Log::error('Navigations table does not exist!');
                return view('welcome')->with('error', 'Navigation table does not exist.');
            }

            // Get all navigation items ordered by the order field
            $navigationItems = Navigation::where('is_active', 1)->orderBy('order')->get();
            
            // Log navigation items for debugging
            Log::info('Navigation Items Count: ' . $navigationItems->count());
            if ($navigationItems->count() > 0) {
                Log::info('Navigation Items: ' . json_encode($navigationItems->toArray()));
            } else {
                Log::warning('No navigation items found in database.');
            }
            
            // Get content for each section based on navigation
            
            // Get hero slides (latest 5)
            $heroSlides = HeroSlide::latest('id')
                ->take(5)
                ->get();
                
            // Get works for Featured Works section
            $works = Work::latest()
                ->take(6)
                ->get();
                
            // Get published blog posts
            $blogs = Blog::where('is_published', true)
                ->latest()
                ->take(3)
                ->get();
                
            // Get testimonials
            $testimonials = Testimonial::latest()
                ->get();
                
            // Get active CV data
            $zhyarCv = ZhyarCV::where('is_active', true)->latest()->first();

            // Get location data if available
            $location = null;
            if (Schema::hasTable('location')) {
                $location = Location::first();
            }
                
            // Parse navigation items to determine which sections to display
            $sections = [];
            foreach ($navigationItems as $navItem) {
                $type = strtolower(str_replace('#', '', $navItem->url));
                
                if (str_contains($type, 'works')) {
                    $sections['works'] = true;
                } elseif (str_contains($type, 'blog')) {
                    $sections['blogs'] = true;
                } elseif (str_contains($type, 'testimonial')) {
                    $sections['testimonials'] = true;
                } elseif (str_contains($type, 'about') || str_contains($navItem->name, 'About')) {
                    $sections['about'] = true;
                } elseif (str_contains($type, 'contact')) {
                    $sections['contact'] = true;
                } elseif (str_contains($type, 'cv') || str_contains($navItem->name, 'Zhyar CV')) {
                    $sections['zhyarcv'] = true;
                }
            }
            
            Log::info('Sections to display: ' . json_encode($sections));
                
            return view('welcome', compact(
                'navigationItems',
                'heroSlides',
                'works',
                'blogs',
                'testimonials',
                'sections',
                'zhyarCv',
                'location'
            ));
        } catch (\Exception $e) {
            Log::error('Error in WelcomeController: ' . $e->getMessage());
            return view('welcome')->with('error', 'An error occurred while loading the page.');
        }
    }
}
