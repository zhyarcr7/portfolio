<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Toastr CSS for notifications -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        
            <style>
            /* Custom styles for navigation */
            .nav-gradient {
                background: linear-gradient(135deg, #4b0600 0%, #FF750F 100%);
                box-shadow: 0 4px 20px rgba(255, 117, 15, 0.3);
            }
            .nav-item {
                position: relative;
                transition: all 0.3s ease;
            }
            .nav-item::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: -3px;
                left: 0;
                background-color: #fff;
                transition: width 0.3s ease;
            }
            .nav-item:hover::after {
                width: 100%;
            }
            .auth-button {
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
                z-index: 1;
            }
            .auth-button::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: all 0.5s ease;
                z-index: -1;
            }
            .auth-button:hover::before {
                left: 100%;
            }
            .logo-text {
                font-family: 'Poppins', sans-serif;
                font-weight: 700;
                letter-spacing: 1px;
                background: linear-gradient(to right, #ffffff, #ffd7bf);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .nav-menu-indicator {
                display: inline-block;
                position: relative;
                width: 24px;
                height: 24px;
            }
            .nav-menu-indicator span {
                position: absolute;
                height: 2px;
                width: 100%;
                background: #ffffff;
                border-radius: 2px;
                opacity: 1;
                left: 0;
                transform: rotate(0deg);
                transition: .25s ease-in-out;
            }
            .nav-menu-indicator span:nth-child(1) {
                top: 6px;
            }
            .nav-menu-indicator span:nth-child(2), .nav-menu-indicator span:nth-child(3) {
                top: 12px;
            }
            .nav-menu-indicator span:nth-child(4) {
                top: 18px;
            }
            
            /* Hero slider animations */
            .slide-content {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s ease-out 0.5s;
            }
            
            .slide.active .slide-content {
                opacity: 1;
                transform: translateY(0);
            }
            
            .slide-element {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.5s ease-out;
            }
            
            .slide.active .slide-element-1 {
                opacity: 1;
                transform: translateY(0);
                transition-delay: 0.3s;
            }
            
            .slide.active .slide-element-2 {
                opacity: 1;
                transform: translateY(0);
                transition-delay: 0.5s;
            }
            
            .slide.active .slide-element-3 {
                opacity: 1;
                transform: translateY(0);
                transition-delay: 0.7s;
            }
            
            .slide.active .slide-element-4 {
                opacity: 1;
                transform: translateY(0);
                transition-delay: 0.9s;
            }
            
            .slide.active .slide-element-5 {
                opacity: 1;
                transform: translateY(0);
                transition-delay: 1.1s;
            }
            
            .pagination-dot {
                transition: all 0.3s ease;
            }
            
            .pagination-dot.active {
                transform: scale(1.3);
            }
            
            /* Zoom effect for slide background */
            .slide-bg {
                transition: transform 8s ease;
            }
            
            .slide.active .slide-bg {
                transform: scale(1.1);
            }

            /* Fix for slider and content sections */
            .hero-slider-container {
                position: relative;
                height: 70vh;
                width: 100%;
                overflow: hidden;
                margin-bottom: 2rem;
            }
            .slides-container {
                position: relative;
                height: 100%;
                width: 100%;
            }
            .slide {
                position: absolute;
                inset: 0;
                z-index: 0;
                opacity: 0;
                transition: opacity 1s ease;
            }
            .slide.active {
                z-index: 10;
                opacity: 1;
            }
            .main-content {
                position: relative;
                z-index: 20;
                background-color: #161615;
            }
            .dark .main-content {
                background-color: #0a0a0a;
            }
            /* Section headings */
            .section-heading {
                position: relative;
                z-index: 10;
                margin-bottom: 2rem;
            }
            </style>
    </head>
    <body class="bg-[#161615] dark:bg-[#0a0a0a] text-gray-200 flex flex-col min-h-screen w-full">
        <!-- Modern Navigation Bar -->
        <header class="w-full fixed top-0 left-0 right-0 z-50">
            <div class="nav-gradient py-3 md:py-4 px-4 md:px-6">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <div class="text-white mr-2">
                            <svg width="36" height="36" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25 5C13.954 5 5 13.954 5 25C5 36.046 13.954 45 25 45C36.046 45 45 36.046 45 25C45 13.954 36.046 5 25 5ZM25 42C15.611 42 8 34.389 8 25C8 15.611 15.611 8 25 8C34.389 8 42 15.611 42 25C42 34.389 34.389 42 25 42Z" fill="white"/>
                                <path d="M32.5 22.5L25 30L17.5 22.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h1 class="logo-text text-lg md:text-xl lg:text-2xl">Zhyar's Portfolio</h1>
                    </div>
                    
                    <!-- Desktop Navigation Menu -->
                    <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                        @if(isset($navigationItems) && count($navigationItems) > 0)
                            @foreach($navigationItems as $navItem)
                                <a href="{{ $navItem->url }}" class="nav-item text-white hover:text-white/90" target="{{ $navItem->target }}">
                                    @if($navItem->icon)
                                        <i class="{{ $navItem->icon }} mr-1"></i>
                                    @endif
                                    {{ $navItem->name }}
                                </a>
                            @endforeach
                        @else
                            <!-- Fallback navigation if database items aren't loaded -->
                            <a href="/" class="nav-item text-white hover:text-white/90"><i class="fas fa-home mr-1"></i> Home</a>
                            <a href="#works" class="nav-item text-white hover:text-white/90"><i class="fas fa-briefcase mr-1"></i> Works</a>
                            <a href="#blogs" class="nav-item text-white hover:text-white/90"><i class="fas fa-blog mr-1"></i> Blogs</a>
                            <a href="#testimonials" class="nav-item text-white hover:text-white/90"><i class="fas fa-quote-left mr-1"></i> Testimonials</a>
                            <a href="#about" class="nav-item text-white hover:text-white/90"><i class="fas fa-user mr-1"></i> About</a>
                            <a href="#contact" class="nav-item text-white hover:text-white/90"><i class="fas fa-envelope mr-1"></i> Contact</a>
                            <a href="#zhyarcv" class="nav-item text-white hover:text-white/90"><i class="fas fa-file mr-1"></i> Zhyar CV</a>
                        @endif
                    </div>
                    
                    <!-- Authentication Links -->
                    <div class="site-menu flex items-center ml-auto gap-3">
                        @if (Route::has('user.login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="auth-button px-5 py-2 text-white hover:text-white/90">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('user.login') }}" class="auth-button px-5 py-2 text-white hover:text-white/90">
                                    {{ __('Log in') }}
                                </a>

                                @if (Route::has('user.register'))
                                    <a href="{{ route('user.register') }}" class="auth-button px-5 py-2 rounded-full border-2 border-white text-white hover:bg-white/10">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button type="button" class="text-white focus:outline-none" id="mobile-menu-button">
                            <div class="nav-menu-indicator">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Menu (Hidden by default) -->
            <div class="hidden md:hidden bg-[#4b0600] py-4 px-6 shadow-lg" id="mobile-menu">
                <div class="flex flex-col space-y-4">
                    @if(isset($navigationItems) && count($navigationItems) > 0)
                        @foreach($navigationItems as $navItem)
                            <a href="{{ $navItem->url }}" class="text-white hover:text-white/90 py-2 border-b border-white/10" target="{{ $navItem->target }}">
                                @if($navItem->icon)
                                    <i class="{{ $navItem->icon }} mr-2 w-6 text-center"></i>
                                @endif
                                {{ $navItem->name }}
                            </a>
                        @endforeach
                    @endif
                    
                    <!-- Mobile menu links -->
                    <div class="py-4">
                        @if (Route::has('user.login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block py-2 text-white hover:text-white/90">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('user.login') }}" class="block py-2 text-white hover:text-white/90">
                                    {{ __('Log in') }}
                                </a>

                                @if (Route::has('user.register'))
                                    <a href="{{ route('user.register') }}" class="block py-2 text-white hover:text-white/90">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Add space to account for the fixed header -->
        <div class="h-24 w-full"></div>

        <!-- Hero Slider Section -->
        <div class="hero-slider-container">
                @php
                    use Illuminate\Support\Str;
                    
                    $activeSlides = \App\Models\HeroSlide::where('is_active', 1)
                        ->latest('id')
                        ->take(5)
                        ->get();
                    if(count($activeSlides) == 0) {
                        // Create a default slide if no slides are in the database
                        $activeSlides = collect([
                            (object)[
                                'title' => 'Welcome to My Portfolio',
                                'subtitle' => 'Showcasing my creative work and professional projects',
                                'description' => 'Explore my latest work and get in touch for collaboration opportunities.',
                                'bgImage' => 'https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?auto=format&fit=crop&q=80',
                                'ctaText' => 'View Projects',
                            'ctaLink' => '#works',
                                'secondaryCtaText' => 'Contact Me',
                            'secondaryCtaLink' => '#contact',
                                'highlightedText' => 'Featured'
                            ]
                        ]);
                    }
                @endphp
                <div class="slides-container">
                    @foreach($activeSlides as $index => $slide)
                    <div class="slide {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}">
                            <!-- Slide Background -->
                            <div class="absolute inset-0 bg-cover bg-center slide-bg" style="background-image: url('{{ 
                                !empty($slide->bgImage) 
                                    ? (Str::startsWith($slide->bgImage, 'http') 
                                        ? $slide->bgImage 
                                        : (file_exists(public_path('storage/hero-slides/'.$slide->bgImage)) 
                                            ? asset('storage/hero-slides/'.$slide->bgImage) 
                                            : asset('storage/'.$slide->bgImage)))
                                    : 'https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?auto=format&fit=crop&q=80'
                            }}');">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#4b0600]/90 via-[#4b0600]/70 to-transparent"></div>
                            </div>
                            
                            <!-- Slide Content -->
                            <div class="relative h-full flex items-center px-4 sm:px-6 md:px-16 lg:px-24">
                                <div class="slide-content w-full md:w-2/3 lg:w-1/2 max-w-xl">
                                    @if(isset($slide->highlightedText) && $slide->highlightedText)
                                        <span class="slide-element slide-element-1 inline-block px-4 py-1 bg-[#FF750F] text-white text-sm md:text-base rounded-full mb-3 md:mb-4 shadow-md">
                                            {{ $slide->highlightedText }}
                                        </span>
                                    @endif
                                    
                                    <h1 class="slide-element slide-element-2 text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-2 sm:mb-4 leading-tight">
                                        {{ $slide->title }}
                                    </h1>
                                    
                                    <h2 class="slide-element slide-element-3 text-lg sm:text-xl md:text-2xl text-white/90 mb-3 sm:mb-6">
                                        {{ $slide->subtitle }}
                                    </h2>
                                    
                                    @if(isset($slide->description) && $slide->description)
                                        <p class="slide-element slide-element-4 text-white/80 mb-6 md:mb-8 max-w-lg text-sm sm:text-base">
                                            {{ $slide->description }}
                                        </p>
                                    @endif
                                    
                                    <div class="slide-element slide-element-5 flex flex-wrap gap-3 md:gap-4">
                                        @if(isset($slide->ctaText) && $slide->ctaText)
                                    <a href="{{ $slide->ctaLink ?? '#' }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 rounded-full bg-[#FF750F] text-white font-medium hover:bg-[#FF750F]/90 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                                                {{ $slide->ctaText }}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        @if(isset($slide->secondaryCtaText) && $slide->secondaryCtaText)
                                    <a href="{{ $slide->secondaryCtaLink ?? '#' }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 rounded-full border-2 border-white text-white font-medium hover:bg-white/10 transition-all duration-300 text-sm sm:text-base">
                                                {{ $slide->secondaryCtaText }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows -->
            <button class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-[#FF750F] transition-all duration-300 shadow-lg prev-slide" id="prev-slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            <button class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-[#FF750F] transition-all duration-300 shadow-lg next-slide" id="next-slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                <!-- Pagination Dots -->
            <div class="absolute bottom-4 sm:bottom-6 left-0 right-0 z-20 flex justify-center gap-2 sm:gap-3 pagination-dots">
                    @foreach($activeSlides as $index => $slide)
                <button class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300 pagination-dot {{ $index === 0 ? 'active bg-white' : '' }}" data-index="{{ $index }}"></button>
                    @endforeach
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content w-full flex-grow">
                <!-- Database Content Sections -->
            <div class="w-full px-4">
                    <!-- Featured Works Section -->
                @if(isset($sections['works']) && (is_object($sections['works']) ? $sections['works']->is_active : $sections['works']))
                    <section id="works" class="py-16 border-t border-gray-800">
                        <div class="container mx-auto px-4">
                            <div class="section-heading text-center mb-10">
                            <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">{{ $sections['works']->title ?? 'Featured Works' }}</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                            @if(isset($sections['works']->description))
                            <p class="text-gray-600 dark:text-gray-400 mt-4 max-w-2xl mx-auto">{{ $sections['works']->description }}</p>
                            @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if(isset($works) && count($works) > 0)
                                    @foreach($works as $work)
                                    <div class="bg-[#222222] dark:bg-[#161615] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                                        <div class="h-48 overflow-hidden">
                                            @if($work->image_url)
                                                <img src="{{ $work->image_url }}" alt="{{ $work->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                            @else
                                                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                    <span class="text-gray-500 dark:text-gray-400">No Image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-5">
                                            <h3 class="text-xl font-bold mb-2 text-white dark:text-[#EDEDEC] line-clamp-1">{{ $work->title }}</h3>
                                            <p class="text-gray-300 dark:text-gray-300 text-sm mb-4 line-clamp-3">{{ Str::limit($work->description, 100) }}</p>
                                            
                                            @if($work->technologies)
                                            <div class="mb-4">
                                            <p class="text-xs text-gray-400 dark:text-gray-400 mb-1">Technologies:</p>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach(explode(',', $work->technologies) as $tech)
                                                <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-600 dark:text-gray-300 text-xs">{{ trim($tech) }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <div class="flex justify-between items-center">
                                                <span class="text-xs text-gray-400 dark:text-gray-400">{{ $work->category }}</span>
                                            @if($work->details_link)
                                            <a href="{{ $work->details_link }}" target="_blank" class="text-sm text-[#FF750F] hover:text-[#4b0600] flex items-center">
                                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                                </a>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full bg-gray-100 dark:bg-gray-800 rounded-lg p-10 text-center">
                                    <div class="text-[#FF750F] text-5xl mb-4"><i class="fas fa-briefcase"></i></div>
                                        <h3 class="text-xl font-bold mb-2 dark:text-white">No Works Found</h3>
                                    <p class="text-gray-400 dark:text-gray-400">Featured works will be added soon.</p>
                                    </div>
                                @endif
                            </div>
                            
                        @if(isset($works) && count($works) > 3) {{-- Assuming pagination or a separate page exists --}}
                            <div class="text-center mt-8">
                                <a href="#" class="inline-flex items-center px-6 py-3 bg-[#FF750F] text-white rounded-md hover:bg-[#4b0600] transition-colors shadow-md hover:shadow-lg">
                                    View All Works <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        @endif
                        </div>
                    </section>
                    @endif
                    
                    <!-- Blog Section -->
                @if(isset($sections['blogs']) && (is_object($sections['blogs']) ? $sections['blogs']->is_active : $sections['blogs']))
                    <section id="blogs" class="py-16 bg-[#1a1a1a] dark:bg-[#1F1F1E]">
                        <div class="container mx-auto px-4">
                            <div class="section-heading text-center mb-10">
                            <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">{{ $sections['blogs']->title ?? 'Latest Blog Posts' }}</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                             @if(isset($sections['blogs']->description))
                            <p class="text-gray-600 dark:text-gray-400 mt-4 max-w-2xl mx-auto">{{ $sections['blogs']->description }}</p>
                            @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if(isset($blogs) && count($blogs) > 0)
                                    @foreach($blogs as $blog)
                                    <div class="bg-[#222222] dark:bg-[#161615] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                                        <div class="h-48 overflow-hidden bg-gray-100 dark:bg-gray-800">
                                            @if(isset($blog->image) && $blog->image)
                                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-file-alt text-4xl text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-5">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="bg-[#FF750F] bg-opacity-10 text-[#FF750F] text-xs px-2 py-1 rounded truncate max-w-[120px]">{{ $blog->category->name ?? 'General' }}</span>
                                            <span class="text-xs text-gray-400 dark:text-gray-400">{{ $blog->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <h3 class="text-xl font-bold mb-2 text-white dark:text-[#EDEDEC] line-clamp-1">{{ $blog->title }}</h3>
                                        <p class="text-gray-300 dark:text-gray-300 text-sm mb-4 line-clamp-3">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 100) }}</p>
                                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-sm text-[#FF750F] hover:text-[#4b0600] flex items-center">
                                                Read More <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg p-10 text-center">
                                    <div class="text-[#FF750F] text-5xl mb-4"><i class="fas fa-blog"></i></div>
                                        <h3 class="text-xl font-bold mb-2 dark:text-white">No Blog Posts Found</h3>
                                    <p class="text-gray-400 dark:text-gray-400">Blog posts will be added soon.</p>
                                    </div>
                                @endif
                            </div>
                            
                        @if(isset($blogs) && count($blogs) > 3) {{-- Assuming pagination or a separate page exists --}}
                            <div class="text-center mt-8">
                                <a href="#" class="inline-flex items-center px-6 py-3 bg-[#FF750F] text-white rounded-md hover:bg-[#4b0600] transition-colors shadow-md hover:shadow-lg">
                                    View All Posts <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        @endif
                        </div>
                    </section>
                    @endif
                    
                    <!-- Testimonials Section -->
                @if(isset($sections['testimonials']) && (is_object($sections['testimonials']) ? $sections['testimonials']->is_active : $sections['testimonials']))
                    <section id="testimonials" class="py-16 border-t border-gray-800">
                        <div class="container mx-auto px-4">
                            <div class="section-heading text-center mb-10">
                            <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">{{ $sections['testimonials']->title ?? 'Client Testimonials' }}</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                            @if(isset($sections['testimonials']->description))
                            <p class="text-gray-600 dark:text-gray-400 mt-4 max-w-2xl mx-auto">{{ $sections['testimonials']->description }}</p>
                            @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if(isset($testimonials) && count($testimonials) > 0)
                                    @foreach($testimonials as $testimonial)
                                    <div class="bg-[#222222] dark:bg-[#161615] rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="flex items-center mb-4">
                                            <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mr-4 flex-shrink-0">
                                                @if(isset($testimonial->image) && $testimonial->image)
                                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-[#FF750F]">
                                                        <span class="text-white font-bold text-lg">{{ substr($testimonial->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-bold text-white dark:text-[#EDEDEC] truncate">{{ $testimonial->name }}</h4>
                                            <p class="text-sm text-gray-300 dark:text-gray-300 truncate">{{ $testimonial->position }} {{ $testimonial->company ? 'at ' . $testimonial->company : '' }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                        @if(isset($testimonial->rating))
                                            <div class="flex text-yellow-400 mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $testimonial->rating ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                            </div>
                                        @endif
                                            <p class="text-gray-300 dark:text-gray-300 text-sm sm:text-base">{{ $testimonial->feedback }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg p-10 text-center">
                                    <div class="text-[#FF750F] text-5xl mb-4"><i class="fas fa-quote-right"></i></div>
                                        <h3 class="text-xl font-bold mb-2 dark:text-white">No Testimonials Found</h3>
                                    <p class="text-gray-400 dark:text-gray-400">Testimonials will be added soon.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                    @endif
                    
                    <!-- Zhyar CV Section -->
                @if(isset($sections['zhyarcv']) && (is_object($sections['zhyarcv']) ? $sections['zhyarcv']->is_active : $sections['zhyarcv']))
                    <section id="zhyarcv" class="py-16 bg-[#1a1a1a] dark:bg-[#1F1F1E]">
                        <div class="container mx-auto px-4">
                            <div class="section-heading text-center mb-10">
                            <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">{{ $sections['zhyarcv']->title ?? "Zhyar's CV" }}</h2>
                             @if(isset($sections['zhyarcv']->description))
                            <p class="text-gray-600 dark:text-gray-400 mt-4 max-w-2xl mx-auto">{{ $sections['zhyarcv']->description }}</p>
                            @endif
                            </div>

                        <div class="bg-[#222222] dark:bg-[#161615] rounded-lg p-4 md:p-6 lg:p-8 shadow-xl mx-auto max-w-4xl">
                                @if(isset($zhyarCv))
                                <div class="mb-6 border-b pb-5">
                                    <h3 class="text-3xl font-bold mb-3 text-white dark:text-[#EDEDEC]">Professional Summary</h3>
                                    <h4 class="text-xl font-semibold mb-3 text-[#FF750F]">{{ $zhyarCv->title }}</h4>
                                    <p class="text-gray-300 dark:text-gray-300">{{ $zhyarCv->content }}</p>
                                </div>
                                
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold mb-3 text-white dark:text-[#EDEDEC]">Work Experience</h3>
                                    
                                    @if($zhyarCv->work_experience)
                                        @foreach($zhyarCv->work_experience as $experience)
                                        <div class="mb-4">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                                                <h4 class="text-xl font-semibold text-white dark:text-[#EDEDEC]">{{ $experience['position'] }}</h4>
                                                <span class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-600 dark:text-gray-300 inline-block sm:ml-2 mt-1 sm:mt-0">{{ $experience['year_start'] }} - {{ $experience['year_end'] }}</span>
                                            </div>
                                            <h5 class="text-[#FF750F] mb-2">{{ $experience['company'] }}</h5>
                                            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-1">
                                                @foreach($experience['responsibilities'] as $responsibility)
                                                    <li>{{ $responsibility }}</li>
                                                @endforeach
                    </ul>
                </div>
                                        @endforeach
                                    @endif
                                </div>
                                
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold mb-3 text-white dark:text-[#EDEDEC]">Skills</h3>
                                    
                                    @if($zhyarCv->skills)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                            @php
                                                $skillsData = is_string($zhyarCv->skills) ? json_decode($zhyarCv->skills, true) : $zhyarCv->skills;
                                            @endphp
                                            
                                            @if(is_array($skillsData))
                                                @foreach($skillsData as $category => $skills)
                                                <div>
                                                    <h4 class="font-semibold mb-2 text-white dark:text-[#EDEDEC]">{{ $category }}</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($skills as $skill)
                                                            <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-600 dark:text-gray-300 text-sm">{{ $skill }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                            @else
                                                <div class="col-span-2">
                                                    <p class="text-gray-500">Skills data format is invalid.</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                
                                @if($zhyarCv->education)
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold mb-3 text-white dark:text-[#EDEDEC]">Education</h3>
                                    
                                    @php
                                        $educationData = is_string($zhyarCv->education) ? json_decode($zhyarCv->education, true) : $zhyarCv->education;
                                    @endphp
                                    
                                    @if(is_array($educationData))
                                        @foreach($educationData as $edu)
                                        <div class="mb-3">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1">
                                                <h4 class="text-lg font-semibold text-white dark:text-[#EDEDEC]">{{ $edu['degree'] }}</h4>
                                                <span class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-600 dark:text-gray-300 inline-block sm:ml-2 mt-1 sm:mt-0">{{ $edu['year_start'] }} - {{ $edu['year_end'] }}</span>
                                            </div>
                                                <h5 class="font-medium text-[#FF750F] dark:text-[#FF750F]">{{ $edu['institution'] }}, {{ $edu['location'] }}</h5>
                                            @if(isset($edu['description']))
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $edu['description'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                    @else
                                        <p class="text-gray-500">Education data format is invalid.</p>
                                    @endif
                                </div>
                                @endif
                                
                                @if($zhyarCv->certifications)
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold mb-3 text-white dark:text-[#EDEDEC]">Certifications</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @php
                                            $certificationsData = is_string($zhyarCv->certifications) ? json_decode($zhyarCv->certifications, true) : $zhyarCv->certifications;
                                        @endphp
                                        
                                        @if(is_array($certificationsData))
                                            @foreach($certificationsData as $cert)
                                            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded shadow-sm">
                                                <h4 class="font-semibold text-white dark:text-[#EDEDEC]">{{ $cert['name'] }}</h4>
                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $cert['issuer'] }} • {{ $cert['year'] }}</p>
                                                @if(isset($cert['description']))
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $cert['description'] }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                        @else
                                            <div class="col-span-2">
                                                <p class="text-gray-500">Certifications data format is invalid.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                
                                <div class="text-center pt-5">
                                    @php
                                        $activeCVFile = \App\Models\CVFile::where('is_active', true)->first();
                                    @endphp
                                    
                                    @if($activeCVFile)
                                    <a href="{{ asset('storage/' . $activeCVFile->file_path) }}" download="{{ $activeCVFile->original_filename ?? 'Zhyar-CV.pdf' }}" class="inline-flex items-center px-6 py-3 bg-[#FF750F] text-white rounded-md hover:bg-[#4b0600] transition-colors shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Download Full CV
                                    </a>
                                    @elseif(isset($zhyarCv->file_path) && $zhyarCv->file_path)
                                    <a href="{{ asset('storage/' . $zhyarCv->file_path) }}" download="{{ $zhyarCv->original_filename ?? basename($zhyarCv->file_path) }}" class="inline-flex items-center px-6 py-3 bg-[#FF750F] text-white rounded-md hover:bg-[#4b0600] transition-colors shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Download Full CV
                                    </a>
                                @else
                                <div class="text-center">
                                    <div class="text-5xl text-gray-300 dark:text-gray-700 mb-4"><i class="fas fa-file-alt"></i></div>
                                    <h3 class="text-xl font-bold mb-2 dark:text-white">CV File Not Available</h3>
                                    <p class="text-gray-500 dark:text-gray-400">The CV file will be added soon.</p>
                                    </div>
                                @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </section>
                    @endif
                    
                    <!-- Contact Section -->
                @if(isset($sections['contact']) && (is_object($sections['contact']) ? $sections['contact']->is_active : $sections['contact']))
                <section id="contact" class="py-16 border-t border-gray-800">
                        <div class="container mx-auto px-4">
                            <div class="section-heading text-center mb-10">
                            <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">{{ $sections['contact']->title ?? 'Get In Touch' }}</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                             @if(isset($sections['contact']->description))
                            <p class="text-gray-600 dark:text-gray-400 mt-4 max-w-2xl mx-auto">{{ $sections['contact']->description }}</p>
                            @endif
                            </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="bg-[#222222] dark:bg-[#161615] rounded-lg p-6 shadow-lg">
                                <h3 class="text-2xl font-bold mb-4 text-white dark:text-[#EDEDEC]">Send a Message</h3>
                                
                                @if(session('success'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <span class="block sm:inline">{{ session('success') }}</span>
                                            </div>
                                @endif
                                @if(session('error'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <span class="block sm:inline">{{ session('error') }}</span>
                                            </div>
                                @endif
                                @if ($errors->any())
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        </div>
                                @endif

                                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                                    @csrf
                                            <div>
                                        <label for="name" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Name</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-[#FF750F] focus:border-transparent dark:bg-gray-700 dark:text-white" required>
                                        </div>
                                        
                                            <div>
                                        <label for="email" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Email</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-[#FF750F] focus:border-transparent dark:bg-gray-700 dark:text-white" required>
                                    </div>
                                    
                                    <div>
                                        <label for="subject" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Subject</label>
                                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-[#FF750F] focus:border-transparent dark:bg-gray-700 dark:text-white" required>
                                    </div>
                                    
                                    <div>
                                        <label for="message" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Message</label>
                                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-[#FF750F] focus:border-transparent dark:bg-gray-700 dark:text-white" required>{{ old('message') }}</textarea>
                                </div>
                                
                                    <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-[#4b0600] to-[#FF750F] text-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                        <i class="fas fa-paper-plane mr-2"></i> Send Message
                                    </button>
                                </form>
                                        </div>
                            
                            <!-- Contact Information -->
                            <div class="bg-[#222222] dark:bg-[#161615] rounded-lg p-6 shadow-lg flex flex-col">
                                <h3 class="text-2xl font-bold mb-6 text-white dark:text-[#EDEDEC]">Contact Information</h3>
                                
                                <div class="space-y-6 flex-grow">
                                    @if($contactInfo && $contactInfo->email)
                                    <div class="flex items-start">
                                        <div class="bg-[#FF750F]/10 p-3 rounded-full mr-4 flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                            <i class="fas fa-envelope text-[#FF750F]"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white dark:text-[#EDEDEC]">Email</h4>
                                            <a href="mailto:{{ $contactInfo->email }}" class="text-gray-600 dark:text-gray-400 hover:text-[#FF750F] dark:hover:text-[#FF750F] transition break-all">{{ $contactInfo->email }}</a>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($contactInfo && $contactInfo->phone)
                                    <div class="flex items-start">
                                        <div class="bg-[#FF750F]/10 p-3 rounded-full mr-4 flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                            <i class="fas fa-phone-alt text-[#FF750F]"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white dark:text-[#EDEDEC]">Phone</h4>
                                            <a href="tel:{{ $contactInfo->phone }}" class="text-gray-600 dark:text-gray-400 hover:text-[#FF750F] dark:hover:text-[#FF750F] transition">{{ $contactInfo->phone }}</a>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($contactInfo && ($contactInfo->address || $contactInfo->city || $contactInfo->state || $contactInfo->country))
                                    <div class="flex items-start">
                                        <div class="bg-[#FF750F]/10 p-3 rounded-full mr-4 flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                            <i class="fas fa-map-marker-alt text-[#FF750F]"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white dark:text-[#EDEDEC]">Location</h4>
                                            <p class="text-gray-600 dark:text-gray-400">{{ $contactInfo->full_address }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- @if($contactInfo && $contactInfo->website)
                                    <div class="flex items-start">
                                        <div class="bg-[#FF750F]/10 p-3 rounded-full mr-4 flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                            <i class="fas fa-globe text-[#FF750F]"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white dark:text-[#EDEDEC]">Website</h4>
                                            <a href="{{ $contactInfo->website }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-[#FF750F] dark:hover:text-[#FF750F] transition break-all">{{ $contactInfo->website }}</a>
                                        </div>
                                    </div>
                                    @endif -->
                                    
                                    @if($contactInfo && $contactInfo->opening_hours)
                                    <div class="flex items-start">
                                        <div class="bg-[#FF750F]/10 p-3 rounded-full mr-4 flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                            <i class="fas fa-clock text-[#FF750F]"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white dark:text-[#EDEDEC]">Opening Hours</h4>
                                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $contactInfo->opening_hours }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                @php
                                    // Default social links
                                    $defaultSocialLinks = [
                                        ['platform' => 'LinkedIn', 'icon_class' => 'fab fa-linkedin-in', 'url' => '#'],
                                        ['platform' => 'GitHub', 'icon_class' => 'fab fa-github', 'url' => '#'],
                                        ['platform' => 'Behance', 'icon_class' => 'fab fa-behance', 'url' => '#'],
                                        ['platform' => 'Instagram', 'icon_class' => 'fab fa-instagram', 'url' => '#']
                                    ];
                                    
                                    $socialLinks = collect($defaultSocialLinks);
                                    
                                    // Check if SocialLink model exists and use it if available
                                    if(class_exists('App\Models\SocialLink')) {
                                        $dbSocialLinks = \App\Models\SocialLink::where('is_active', 1)->orderBy('order', 'asc')->get();
                                        if($dbSocialLinks->count() > 0) {
                                            $socialLinks = $dbSocialLinks;
                                        }
                                    }
                                @endphp
                                
                                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <h4 class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-3">Follow Me</h4>
                                            <div class="flex space-x-4">
                                        @foreach($socialLinks as $link)
                                        <a href="{{ $link['url'] ?? $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer" title="{{ $link['platform'] ?? $link->platform ?? '' }}" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[#FF750F] hover:bg-[#FF750F] hover:text-white transition duration-300">
                                            <i class="{{ $link['icon_class'] ?? $link->icon_class ?? 'fab fa-link' }}"></i>
                                        </a>
                                        @endforeach
                                            </div>
                                        </div>
                                
                                @if($contactInfo && $contactInfo->map_url)
                                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <h4 class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-3">Find Us</h4>
                                    <div class="w-full h-48 rounded-lg overflow-hidden">
                                        <iframe src="{{ $contactInfo->map_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </section>
                    @endif
            </div> <!-- End Database Content Sections -->
                        </div>
            </main>

    <!-- Footer -->
    <footer class="py-8 bg-[#1b1b18] text-white mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                 <!-- Footer About -->
                        <div>
                    <h3 class="text-xl font-bold mb-4">Zhyar CV</h3>
                    <p class="text-gray-400 mb-4 text-sm">Showcasing experience, skills, and creative work in UX/UI design & web development.</p>
                    <div class="flex space-x-4">
                        @foreach($socialLinks as $link)
                         <a href="{{ $link['url'] ?? $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer" title="{{ $link['platform'] ?? $link->platform ?? '' }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300">
                            <i class="{{ $link['icon_class'] ?? $link->icon_class ?? 'fab fa-link' }}"></i>
                        </a>
                        @endforeach
                            </div>
                        </div>
                        
                <!-- Footer Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                         @if(isset($sections['works']) && (is_object($sections['works']) ? $sections['works']->is_active : $sections['works']))<li><a href="#works" class="text-gray-400 hover:text-white transition">Works</a></li>@endif
                         @if(isset($sections['blogs']) && (is_object($sections['blogs']) ? $sections['blogs']->is_active : $sections['blogs']))<li><a href="#blogs" class="text-gray-400 hover:text-white transition">Blogs</a></li>@endif
                         @if(isset($sections['testimonials']) && (is_object($sections['testimonials']) ? $sections['testimonials']->is_active : $sections['testimonials']))<li><a href="#testimonials" class="text-gray-400 hover:text-white transition">Testimonials</a></li>@endif
                         @if(isset($sections['zhyarcv']) && (is_object($sections['zhyarcv']) ? $sections['zhyarcv']->is_active : $sections['zhyarcv']))<li><a href="#zhyarcv" class="text-gray-400 hover:text-white transition">CV</a></li>@endif
                         @if(isset($sections['contact']) && (is_object($sections['contact']) ? $sections['contact']->is_active : $sections['contact']))<li><a href="#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>@endif
                            </ul>
                        </div>
                        
                <!-- Footer Contact -->
                <div>
                     <h3 class="text-xl font-bold mb-4">Contact Info</h3>
                    <ul class="space-y-3 text-sm">
                        @if($contactInfo && $contactInfo->email)
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-[#FF750F] flex-shrink-0 w-4 text-center"></i>
                            <span class="text-gray-400 break-all">{{ $contactInfo->email }}</span>
                        </li>
                        @endif
                        @if($contactInfo && $contactInfo->phone)
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-[#FF750F] flex-shrink-0 w-4 text-center"></i>
                            <span class="text-gray-400">{{ $contactInfo->phone }}</span>
                        </li>
                        @endif
                        @if($contactInfo && ($contactInfo->address || $contactInfo->city || $contactInfo->state || $contactInfo->country))
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-[#FF750F] flex-shrink-0 w-4 text-center"></i>
                            <span class="text-gray-400">{{ $contactInfo->full_address }}</span>
                        </li>
                        @endif
                        @if($contactInfo && $contactInfo->website)
                        <li class="flex items-start">
                            <i class="fas fa-globe mt-1 mr-3 text-[#FF750F] flex-shrink-0 w-4 text-center"></i>
                            <a href="{{ $contactInfo->website }}" target="_blank" class="text-gray-400 hover:text-[#FF750F]">{{ $contactInfo->website }}</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- Footer Copyright -->
            <div class="border-t border-gray-700 pt-6 text-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Zhyar. All rights reserved.</p>
                </div>
            </div>
        </footer>
        
    <!-- JS Scripts -->
    {{-- Include jQuery if needed for plugins like Slick --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
            const menuIndicatorSpans = mobileMenuButton ? mobileMenuButton.querySelectorAll('span') : [];
                
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    // Animate burger icon
                     menuIndicatorSpans[0].classList.toggle('rotate-45');
                     menuIndicatorSpans[0].classList.toggle('top-1/2');
                     menuIndicatorSpans[0].classList.toggle('-translate-y-1/2');
                     menuIndicatorSpans[1].classList.toggle('opacity-0');
                     menuIndicatorSpans[2].classList.toggle('opacity-0');
                     menuIndicatorSpans[3].classList.toggle('-rotate-45');
                     menuIndicatorSpans[3].classList.toggle('top-1/2');
                     menuIndicatorSpans[3].classList.toggle('-translate-y-1/2');
                });
            }

            // Basic Hero Slider Logic (if Slick Carousel is not used/available)
            const sliderContainer = document.querySelector('.slides-container');
            if (sliderContainer) {
                const slides = sliderContainer.querySelectorAll('.slide');
                const prevButton = document.getElementById('prev-slide');
                const nextButton = document.getElementById('next-slide');
                const dotsContainer = document.querySelector('.pagination-dots');
                let currentSlide = 0;
                let slideInterval;
                
                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        slide.classList.remove('active', 'opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'z-0');
                        if (i === index) {
                            slide.classList.add('active', 'opacity-100', 'z-10');
                            slide.classList.remove('opacity-0', 'z-0');
                        }
                    });
                    if(dotsContainer){
                        const dots = dotsContainer.querySelectorAll('.pagination-dot');
                         dots.forEach((dot, i) => {
                        dot.classList.remove('active', 'bg-white', 'text-[#4b0600]');
                             dot.classList.add('bg-white/50');
                             if (i === index) {
                                 dot.classList.add('active', 'bg-white', 'text-[#4b0600]');
                                 dot.classList.remove('bg-white/50');
                             }
                         });
                    }
                    currentSlide = index;
                }
                
                function next() {
                    let nextIndex = (currentSlide + 1) % slides.length;
                    showSlide(nextIndex);
                }

                function prev() {
                     let prevIndex = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(prevIndex);
                }

                function startSlider() {
                    stopSlider(); // Clear existing interval first
                    slideInterval = setInterval(next, 5000); // Change slide every 5 seconds
                }
                
                function stopSlider() {
                    clearInterval(slideInterval);
                }

                if (slides.length > 1) {
                    if(prevButton) prevButton.addEventListener('click', () => { prev(); stopSlider(); startSlider(); });
                    if(nextButton) nextButton.addEventListener('click', () => { next(); stopSlider(); startSlider(); });
                    
                    if(dotsContainer){
                         const dots = dotsContainer.querySelectorAll('.pagination-dot');
                         dots.forEach(dot => {
                             dot.addEventListener('click', function() {
                                 showSlide(parseInt(this.dataset.index));
                                 stopSlider();
                                 startSlider();
                             });
                         });
                    }
                    
                    // Pause on hover
                    const heroSlider = document.querySelector('.hero-slider-container');
                    if(heroSlider){
                         heroSlider.addEventListener('mouseenter', stopSlider);
                         heroSlider.addEventListener('mouseleave', startSlider);
                    }

                    startSlider(); // Start autoplay
                    showSlide(0); // Show the first slide initially
                } else if (slides.length === 1) {
                     // If only one slide, ensure it's active and hide controls
                     slides[0].classList.add('active', 'opacity-100', 'z-10');
                     slides[0].classList.remove('opacity-0', 'z-0');
                     if(prevButton) prevButton.style.display = 'none';
                     if(nextButton) nextButton.style.display = 'none';
                     if(dotsContainer) dotsContainer.style.display = 'none';
                }
            }
            
            // Dark mode toggle (if needed and not handled by app.js)
            // Example: Add a button with id="dark-mode-toggle"
             const darkModeToggle = document.getElementById('dark-mode-toggle'); // Assuming you add this button
             const htmlElement = document.documentElement;
             if (darkModeToggle) {
                // Initial check
                if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    htmlElement.classList.add('dark');
                } else {
                    htmlElement.classList.remove('dark');
                }
                
                darkModeToggle.addEventListener('click', () => {
                    if (htmlElement.classList.contains('dark')) {
                        htmlElement.classList.remove('dark');
                        localStorage.theme = 'light';
                    } else {
                        htmlElement.classList.add('dark');
                        localStorage.theme = 'dark';
                    }
                });
             }

            });
        </script>
        
        <!-- jQuery and Toastr for notifications -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            // Configure toastr options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            
            // Check for flash messages and display toasts
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    toastr.success('{{ session('success') }}');
                @endif
                
                @if(session('error'))
                    toastr.error('{{ session('error') }}');
                @endif
                
                @if(session('info'))
                    toastr.info('{{ session('info') }}');
                @endif
                
                @if(session('warning'))
                    toastr.warning('{{ session('warning') }}');
                @endif
            });
        </script>
        
        <!-- Contact Form JavaScript -->
        <script src="{{ asset('js/contact-form.js') }}"></script>
        
        <script>
            // CSRF Token refresh to prevent 419 errors
            document.addEventListener('DOMContentLoaded', function() {
                // Refresh CSRF token every 2 hours (7200000 ms)
                setInterval(function() {
                    fetch('/csrf-token')
                        .then(response => response.json())
                        .then(data => {
                            let token = data.token;
                            document.querySelectorAll('input[name="_token"]').forEach(function(input) {
                                input.value = token;
                            });
                        })
                        .catch(error => console.error('Error refreshing CSRF token:', error));
                }, 7200000);
            });
        </script>
    </body>
</html>
