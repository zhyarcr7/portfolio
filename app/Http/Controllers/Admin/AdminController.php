<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function dashboard()
    {
        $counts = [
            'blogs' => \App\Models\Blog::count(),
            'slides' => \App\Models\HeroSlide::count(),
            'works' => \App\Models\Work::count(),
            'navigation' => \App\Models\Navigation::count(),
            'testimonials' => \App\Models\Testimonial::count(),
            'comingSoon' => \App\Models\ComingSoon::count(),
        ];
        
        return view('dashboard', compact('counts'));
    }
} 