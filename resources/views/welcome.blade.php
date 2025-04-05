<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
            </style>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col w-full">
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
                    @if (Route::has('login'))
                        <div class="hidden md:flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="auth-button px-5 py-2 rounded-full border-2 border-white text-white hover:bg-white/10">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="auth-button px-5 py-2 text-white hover:text-white/90">
                                    Login
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="auth-button px-5 py-2 rounded-full border-2 border-white text-white hover:bg-white/10">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                    
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
                    
                    @if (Route::has('login'))
                        <div class="pt-4 border-t border-white/20">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block py-2 text-white hover:text-white/90">
                                    <i class="fas fa-tachometer-alt mr-2 w-6 text-center"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block py-2 text-white hover:text-white/90">
                                    <i class="fas fa-sign-in-alt mr-2 w-6 text-center"></i> Login
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block py-2 text-white hover:text-white/90">
                                        <i class="fas fa-user-plus mr-2 w-6 text-center"></i> Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <!-- Add space to account for the fixed header -->
        <div class="h-24 w-full"></div>

        <!-- Hero Slider Section -->
        <div class="w-full overflow-hidden mb-12 md:mb-16">
            <div class="hero-slider relative h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[80vh]">
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
                                'ctaLink' => '#',
                                'secondaryCtaText' => 'Contact Me',
                                'secondaryCtaLink' => '#',
                                'highlightedText' => 'Featured'
                            ]
                        ]);
                    }
                @endphp
                
                <!-- Slider Container -->
                <div class="slides-container">
                    @foreach($activeSlides as $index => $slide)
                        <div class="slide absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100 z-10 active' : 'opacity-0 z-0' }}" 
                             data-slide-index="{{ $index }}">
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
                                            <a href="{{ $slide->ctaLink }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 rounded-full bg-[#FF750F] text-white font-medium hover:bg-[#FF750F]/90 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                                                {{ $slide->ctaText }}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        @if(isset($slide->secondaryCtaText) && $slide->secondaryCtaText)
                                            <a href="{{ $slide->secondaryCtaLink }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 rounded-full border-2 border-white text-white font-medium hover:bg-white/10 transition-all duration-300 text-sm sm:text-base">
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
                <button class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-[#FF750F] transition-all duration-300 shadow-lg" id="prev-slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-[#FF750F] transition-all duration-300 shadow-lg" id="next-slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                <!-- Pagination Dots -->
                <div class="absolute bottom-4 sm:bottom-6 left-0 right-0 z-20 flex justify-center gap-2 sm:gap-3">
                    @foreach($activeSlides as $index => $slide)
                        <button class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-white/20 hover:bg-white/60 transition-all duration-300 flex items-center justify-center text-white text-xs font-bold pagination-dot {{ $index === 0 ? 'active bg-white text-[#4b0600]' : '' }}" data-index="{{ $index }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Original content continues here -->
        <div class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4 hidden">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
        
        <!-- Rest of the original content -->
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full flex-col-reverse lg:flex-row">
                <!-- Database Content Sections -->
                <div class="w-full mt-8 px-4">
                    <!-- Featured Works Section -->
                    @if(isset($sections['works']))
                    <section id="works" class="py-16 border-t">
                        <div class="container mx-auto px-4">
                            <div class="text-center mb-10">
                                <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">Featured Works</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @if(count($works) > 0)
                                    @foreach($works as $work)
                                    <div class="bg-white dark:bg-[#161615] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
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
                                            <h3 class="text-xl font-bold mb-2 text-[#1b1b18] dark:text-[#EDEDEC] line-clamp-1">{{ $work->title }}</h3>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">{{ Str::limit($work->description, 100) }}</p>
                                            
                                            @if($work->technologies)
                                            <div class="mb-4">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Technologies used:</p>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach(explode(',', $work->technologies) as $tech)
                                                    <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-600 dark:text-gray-300 text-xs">{{ $tech }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <div class="flex justify-between items-center">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $work->category }}</span>
                                                <a href="#" class="text-sm text-[#FF750F] hover:text-[#4b0600] flex items-center">
                                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full bg-gray-100 dark:bg-gray-800 rounded-lg p-10 text-center">
                                        <div class="text-[#FF750F] text-5xl mb-4">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                        <h3 class="text-xl font-bold mb-2 dark:text-white">No Works Found</h3>
                                        <p class="text-gray-600 dark:text-gray-400">There are no works to display at the moment.</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-center mt-8">
                                <a href="#" class="inline-flex items-center px-6 py-3 bg-[#FF750F] text-white rounded-md hover:bg-[#4b0600] transition-colors shadow-md hover:shadow-lg">
                                    View All Works <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </section>
                    @endif
                    
                    <!-- Blog Section -->
                    @if(isset($sections['blogs']))
                    <section id="blogs" class="py-16 bg-gray-50 dark:bg-[#1F1F1E]">
                        <div class="container mx-auto px-4">
                            <div class="text-center mb-10">
                                <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">Latest Blog Posts</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @if(count($blogs) > 0)
                                    @foreach($blogs as $blog)
                                    <div class="bg-white dark:bg-[#161615] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                                        <div class="h-48 overflow-hidden bg-gray-100 dark:bg-gray-800">
                                            @if(isset($blog->image) && $blog->image)
                                                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-file-alt text-4xl text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-5">
                                            <div class="flex items-center mb-3">
                                                <span class="bg-[#FF750F] bg-opacity-10 text-[#FF750F] text-xs px-2 py-1 rounded truncate max-w-[120px]">{{ $blog->category ?? 'General' }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-auto">{{ $blog->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <h3 class="text-xl font-bold mb-2 text-[#1b1b18] dark:text-[#EDEDEC] line-clamp-1">{{ $blog->title }}</h3>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">{{ Str::limit($blog->excerpt ?? $blog->content, 100) }}</p>
                                            <a href="#" class="text-sm text-[#FF750F] hover:text-[#4b0600] flex items-center">
                                                Read More <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg p-10 text-center">
                                        <div class="text-[#FF750F] text-5xl mb-4">
                                            <i class="fas fa-blog"></i>
                                        </div>
                                        <h3 class="text-xl font-bold mb-2 dark:text-white">No Blog Posts Found</h3>
                                        <p class="text-gray-600 dark:text-gray-400">There are no blog posts to display at the moment.</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-center mt-8">
                                <a href="#" class="inline-flex items-center px-6 py-3 bg-[#FF750F] text-white rounded-md hover:bg-[#4b0600] transition-colors shadow-md hover:shadow-lg">
                                    View All Posts <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </section>
                    @endif
                    
                    <!-- Testimonials Section -->
                    @if(isset($sections['testimonials']))
                    <section id="testimonials" class="py-16 border-t">
                        <div class="container mx-auto px-4">
                            <div class="text-center mb-10">
                                <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">Client Testimonials</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @if(count($testimonials) > 0)
                                    @foreach($testimonials as $testimonial)
                                    <div class="bg-white dark:bg-[#161615] rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="flex items-center mb-4">
                                            <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mr-4 flex-shrink-0">
                                                @if(isset($testimonial->image) && $testimonial->image)
                                                    <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-[#FF750F]">
                                                        <span class="text-white font-bold text-lg">{{ substr($testimonial->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-bold text-[#1b1b18] dark:text-[#EDEDEC] truncate">{{ $testimonial->name }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $testimonial->position }} at {{ $testimonial->company }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="flex text-yellow-400 mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $testimonial->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">{{ $testimonial->feedback }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg p-10 text-center">
                                        <div class="text-[#FF750F] text-5xl mb-4">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                        <h3 class="text-xl font-bold mb-2 dark:text-white">No Testimonials Found</h3>
                                        <p class="text-gray-600 dark:text-gray-400">There are no testimonials to display at the moment.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                    @endif
                    
                    <!-- Zhyar CV Section -->
                    @if(isset($sections['zhyarcv']))
                    <section id="zhyarcv" class="py-16 bg-gray-50 dark:bg-[#1F1F1E]">
                        <div class="container mx-auto px-4">
                            <div class="text-center mb-10">
                                <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">Zhyar's CV</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                            </div>

                            <div class="bg-white dark:bg-[#161615] rounded-lg p-4 md:p-6 lg:p-8 shadow-xl mx-auto">
                                @if(isset($zhyarCv))
                                <div class="mb-6 border-b pb-5">
                                    <h3 class="text-2xl font-bold mb-3 text-[#1b1b18] dark:text-[#EDEDEC]">Professional Summary</h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        {{ $zhyarCv->summary }}
                                    </p>
                                </div>
                                
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold mb-3 text-[#1b1b18] dark:text-[#EDEDEC]">Work Experience</h3>
                                    
                                    @if($zhyarCv->work_experience)
                                        @foreach($zhyarCv->work_experience as $experience)
                                        <div class="mb-4">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                                                <h4 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $experience['position'] }}</h4>
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
                                    <h3 class="text-2xl font-bold mb-3 text-[#1b1b18] dark:text-[#EDEDEC]">Skills</h3>
                                    
                                    @if($zhyarCv->skills)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                            @php
                                                $skillsData = is_string($zhyarCv->skills) ? json_decode($zhyarCv->skills, true) : $zhyarCv->skills;
                                            @endphp
                                            
                                            @if(is_array($skillsData))
                                                @foreach($skillsData as $category => $skills)
                                                    <div>
                                                        <h4 class="font-semibold mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">{{ $category }}</h4>
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
                                    <h3 class="text-2xl font-bold mb-3 text-[#1b1b18] dark:text-[#EDEDEC]">Education</h3>
                                    
                                    @php
                                        $educationData = is_string($zhyarCv->education) ? json_decode($zhyarCv->education, true) : $zhyarCv->education;
                                    @endphp
                                    
                                    @if(is_array($educationData))
                                        @foreach($educationData as $edu)
                                            <div class="mb-3">
                                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1">
                                                    <h4 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $edu['degree'] }}</h4>
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
                                    <h3 class="text-2xl font-bold mb-3 text-[#1b1b18] dark:text-[#EDEDEC]">Certifications</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @php
                                            $certificationsData = is_string($zhyarCv->certifications) ? json_decode($zhyarCv->certifications, true) : $zhyarCv->certifications;
                                        @endphp
                                        
                                        @if(is_array($certificationsData))
                                            @foreach($certificationsData as $cert)
                                                <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded shadow-sm">
                                                    <h4 class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $cert['name'] }}</h4>
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
                                
                                @if($zhyarCv->cv_file)
                                <div class="text-center pt-3">
                                    <a href="{{ asset('storage/cv_files/' . $zhyarCv->cv_file) }}" download class="inline-flex items-center px-6 py-3 bg-[#FF750F] text-white rounded-md hover:bg-[#4b0600] transition-colors shadow-md hover:shadow-lg">
                                        <i class="fas fa-download mr-2"></i> Download Full CV
                                    </a>
                                </div>
                                @endif
                                @else
                                <div class="text-center">
                                    <div class="text-5xl text-gray-300 dark:text-gray-700 mb-4">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <h3 class="text-xl font-bold mb-2">CV Data Not Available</h3>
                                    <p class="text-gray-500 dark:text-gray-400">CV information will be added soon.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </section>
                    @endif
                    
                    <!-- Contact Section -->
                    @if(isset($sections['contact']))
                    <section id="contact" class="py-16 bg-gray-50 dark:bg-[#1F1F1E]">
                        <div class="container mx-auto px-4">
                            <div class="text-center mb-10">
                                <h2 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] bg-clip-text text-transparent">Get In Touch</h2>
                                <div class="w-20 h-1 bg-gradient-to-r from-[#4b0600] to-[#FF750F] mx-auto"></div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                                <!-- Contact Information -->
                                <div class="bg-white dark:bg-[#161615] rounded-lg p-6 md:p-8 shadow-lg">
                                    <h3 class="text-2xl font-bold mb-6 text-[#1b1b18] dark:text-[#EDEDEC]">Contact Information</h3>
                                    
                                    <div class="space-y-6">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-[#FF750F] p-3 rounded-lg text-white mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Location</h4>
                                                <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm md:text-base">
                                                    {{ isset($location) ? $location->address : '123 Design Street, Creative City, PC 56789' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-[#FF750F] p-3 rounded-lg text-white mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Email</h4>
                                                <p class="text-gray-600 dark:text-gray-300 mt-1 break-all text-sm md:text-base">
                                                    {{ isset($location) ? $location->contact_email : 'contact@example.com' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-[#FF750F] p-3 rounded-lg text-white mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Phone</h4>
                                                <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm md:text-base">
                                                    {{ isset($location) ? $location->phone : '+1 (555) 123-4567' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Social Media Links -->
                                    <div class="mt-8">
                                        <h4 class="text-xl font-bold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">Follow Me</h4>
                                        <div class="flex flex-wrap gap-3">
                                            <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                                </svg>
                                            </a>
                                            <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                                </svg>
                                            </a>
                                            <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                                </svg>
                                            </a>
                                            <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                                    <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                                </svg>
                                            </a>
                                            <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                    </svg>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Google Map -->
                                    <div class="mt-8">
                                        <h4 class="text-xl font-bold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">Find Me</h4>
                                        <div class="rounded-lg overflow-hidden h-[200px] shadow-md">
                                            @if(isset($location) && $location->map_url)
                                                <iframe src="{{ $location->map_url }}" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            @else
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.305935303!2d-74.25986548248684!3d40.69714941932609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2suk!4v1617456744697!5m2!1sen!2suk" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Contact Form -->
                                <div class="bg-white dark:bg-[#161615] rounded-lg p-6 md:p-8 shadow-lg">
                                    <h3 class="text-2xl font-bold mb-6 text-[#1b1b18] dark:text-[#EDEDEC]">Send a Message</h3>
                                    
                                    @if(session('success'))
                                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                                            <p>{{ session('success') }}</p>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                                            <p>{{ session('error') }}</p>
                                        </div>
                                    @endif
                                    
                                    <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                                        @csrf
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Name</label>
                                                <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-[#FF750F] focus:border-[#FF750F] dark:text-white shadow-sm">
                                                <p class="text-red-500 text-xs mt-1 error-message" id="name-error"></p>
                                            </div>
                                            
                                            <div>
                                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Email</label>
                                                <input type="email" name="email" id="email" required value="{{ old('email') }}" class="w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-[#FF750F] focus:border-[#FF750F] dark:text-white shadow-sm">
                                                <p class="text-red-500 text-xs mt-1 error-message" id="email-error"></p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                                            <input type="text" name="subject" id="subject" required value="{{ old('subject') }}" class="w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-[#FF750F] focus:border-[#FF750F] dark:text-white shadow-sm">
                                            <p class="text-red-500 text-xs mt-1 error-message" id="subject-error"></p>
                                        </div>
                                        
                                        <div>
                                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Message</label>
                                            <textarea name="message" id="message" rows="6" required class="w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-[#FF750F] focus:border-[#FF750F] dark:text-white shadow-sm">{{ old('message') }}</textarea>
                                            <p class="text-red-500 text-xs mt-1 error-message" id="message-error"></p>
                                        </div>
                                        
                                        <div id="response-message" class="hidden rounded px-4 py-3 mb-4"></div>
                                        
                                        <div class="flex justify-end">
                                            @auth
                                            <div class="flex space-x-4">
                                                <a href="{{ route('chat.create') }}" class="w-full md:w-auto bg-gradient-to-r from-[#4b0600] to-[#FF750F] text-white py-3 px-6 rounded-lg font-medium hover:opacity-90 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                                                    Send Message
                                                </a>
                                                <button type="submit" id="submit-button" class="w-full md:w-auto bg-gradient-to-r from-[#4b0600] to-[#FF750F] text-white py-3 px-6 rounded-lg font-medium hover:opacity-90 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center">
                                                    <span id="submit-text">Send Email</span>
                                                    <span id="loading-spinner" class="hidden ml-2">
                                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </div>
                                            @else
                                            <button type="submit" id="submit-button" class="w-full bg-gradient-to-r from-[#4b0600] to-[#FF750F] text-white py-3 px-6 rounded-lg font-medium hover:opacity-90 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center">
                                                <span id="submit-text">Send Message</span>
                                                <span id="loading-spinner" class="hidden ml-2">
                                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                </span>
                                            </button>
                                            @endauth
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif
                    
                    <!-- This part section be a dynamic -->
                    @if(isset($error))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ $error }}</span>
                        </div>
                    @endif

                    <!-- Add any new dynamic sections here -->
                    <div id="customContentArea">
                        <!-- This area can be used for any additional dynamic content -->
                    </div>
                </div>

            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
        
        <!-- Modern Footer with Gradient -->
        <footer class="w-full mt-16 md:mt-20">
            <div class="nav-gradient py-8 md:py-10 px-4 md:px-6">
                <div class="max-w-full mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 md:gap-10">
                        <!-- Footer Column 1 - About -->
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="text-white mr-2">
                                    <svg width="28" height="28" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M25 5C13.954 5 5 13.954 5 25C5 36.046 13.954 45 25 45C36.046 45 45 36.046 45 25C45 13.954 36.046 5 25 5ZM25 42C15.611 42 8 34.389 8 25C8 15.611 15.611 8 25 8C34.389 8 42 15.611 42 25C42 34.389 34.389 42 25 42Z" fill="white"/>
                                        <path d="M32.5 22.5L25 30L17.5 22.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h2 class="logo-text text-lg md:text-xl">Portfolio</h2>
                            </div>
                            <p class="text-white/80 mb-4 text-sm">A stunning portfolio showcasing my creative work and skills in web development, design, and digital content creation.</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-white hover:text-white/80 transition-colors duration-300 bg-white/10 hover:bg-white/20 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Footer Column 2 - Quick Links -->
                        <div class="mt-6 sm:mt-0">
                            <h3 class="text-white font-semibold text-lg mb-4">Quick Links</h3>
                            <ul class="grid grid-cols-2 gap-y-2 gap-x-4">
                                @if(isset($navigationItems) && count($navigationItems) > 0)
                                    @foreach($navigationItems as $navItem)
                                        <li><a href="{{ $navItem->url }}" class="text-white/80 hover:text-white transition-colors duration-300 text-sm" target="{{ $navItem->target }}">{{ $navItem->name }}</a></li>
                                    @endforeach
                                @else
                                    <!-- Fallback navigation if database items aren't loaded -->
                                    <li><a href="/" class="text-white/80 hover:text-white transition-colors duration-300 text-sm">Home</a></li>
                                    <li><a href="#works" class="text-white/80 hover:text-white transition-colors duration-300 text-sm">Works</a></li>
                                    <li><a href="#blogs" class="text-white/80 hover:text-white transition-colors duration-300 text-sm">Blogs</a></li>
                                    <li><a href="#testimonials" class="text-white/80 hover:text-white transition-colors duration-300 text-sm">Testimonials</a></li>
                                    <li><a href="#about" class="text-white/80 hover:text-white transition-colors duration-300 text-sm">About</a></li>
                                    <li><a href="#contact" class="text-white/80 hover:text-white transition-colors duration-300 text-sm">Contact</a></li>
                                    <li><a href="#zhyarcv" class="text-white/80 hover:text-white transition-colors duration-300 text-sm">Zhyar CV</a></li>
                                @endif
                            </ul>
                        </div>
                        
                        <!-- Footer Column 3 - Contact -->
                        <div class="mt-6 md:mt-0">
                            <h3 class="text-white font-semibold text-lg mb-4">Contact Info</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-white/80 text-sm">123 Design Street, Creative City, PC 56789</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-white/80 text-sm">contact@example.com</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-white/80 text-sm">+1 (555) 123-4567</span>
                                </li>
                                <li class="pt-4">
                                    <form class="flex flex-col sm:flex-row gap-2">
                                        <input type="email" placeholder="Subscribe to newsletter" class="bg-white/10 text-white placeholder-white/60 rounded-lg sm:rounded-l-lg sm:rounded-r-none py-2 px-4 focus:outline-none text-sm w-full">
                                        <button type="submit" class="bg-white text-[#4b0600] rounded-lg sm:rounded-l-none sm:rounded-r-lg px-4 py-2 font-medium hover:bg-white/90 transition-all duration-300 text-sm whitespace-nowrap">
                                            Subscribe
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="border-t border-white/20 mt-10 pt-6 text-center">
                        <p class="text-white/60 text-sm">© {{ date('Y') }} Portfolio. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Contact Form AJAX -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const contactForm = document.getElementById('contact-form');
                if (contactForm) {
                    contactForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        // Show loading spinner
                        const submitButton = document.getElementById('submit-button');
                        const submitText = document.getElementById('submit-text');
                        const loadingSpinner = document.getElementById('loading-spinner');
                        const responseMessage = document.getElementById('response-message');
                        
                        // Clear previous error messages
                        document.querySelectorAll('.error-message').forEach(el => {
                            el.textContent = '';
                        });
                        
                        // Hide previous response message
                        responseMessage.classList.add('hidden');
                        
                        // Show loading state
                        submitButton.disabled = true;
                        loadingSpinner.classList.remove('hidden');
                        
                        // Get form data
                        const formData = new FormData(contactForm);
                        
                        // Send AJAX request
                        fetch(contactForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Hide loading spinner
                            submitButton.disabled = false;
                            loadingSpinner.classList.add('hidden');
                            
                            if (data.success) {
                                // Show success message
                                responseMessage.textContent = data.message || 'Your message has been sent successfully!';
                                responseMessage.classList.remove('hidden', 'bg-red-100', 'border-red-400', 'text-red-700');
                                responseMessage.classList.add('bg-green-100', 'border', 'border-green-400', 'text-green-700');
                                
                                // Reset form
                                contactForm.reset();
                            } else {
                                // Show general error message
                                responseMessage.textContent = data.message || 'There was an error sending your message. Please try again.';
                                responseMessage.classList.remove('hidden', 'bg-green-100', 'border-green-400', 'text-green-700');
                                responseMessage.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700');
                                
                                // Show validation errors
                                if (data.errors) {
                                    Object.keys(data.errors).forEach(field => {
                                        const errorElement = document.getElementById(`${field}-error`);
                                        if (errorElement) {
                                            errorElement.textContent = data.errors[field][0];
                                        }
                                    });
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Hide loading spinner
                            submitButton.disabled = false;
                            loadingSpinner.classList.add('hidden');
                            
                            // Show error message
                            responseMessage.textContent = 'There was a network error. Please try again.';
                            responseMessage.classList.remove('hidden', 'bg-green-100', 'border-green-400', 'text-green-700');
                            responseMessage.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700');
                        });
                    });
                }
            });
        </script>
        
        <!-- Mobile Menu JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
                
                // Hero Slider Functionality
                const slides = document.querySelectorAll('.slide');
                const dots = document.querySelectorAll('.pagination-dot');
                const prevButton = document.getElementById('prev-slide');
                const nextButton = document.getElementById('next-slide');
                let currentSlide = 0;
                const totalSlides = slides.length;
                
                function showSlide(index) {
                    // Hide all slides
                    slides.forEach(slide => {
                        slide.classList.remove('opacity-100', 'z-10', 'active');
                        slide.classList.add('opacity-0', 'z-0');
                    });
                    
                    // Show the current slide
                    slides[index].classList.remove('opacity-0', 'z-0');
                    slides[index].classList.add('opacity-100', 'z-10', 'active');
                    
                    // Update pagination dots
                    dots.forEach(dot => {
                        dot.classList.remove('active', 'bg-white', 'text-[#4b0600]');
                        dot.classList.add('bg-white/20', 'text-white');
                    });
                    dots[index].classList.add('active', 'bg-white', 'text-[#4b0600]');
                    dots[index].classList.remove('bg-white/20', 'text-white');
                    
                    currentSlide = index;
                }
                
                // Auto-advance slides
                let slideInterval = setInterval(() => {
                    let nextIndex = (currentSlide + 1) % totalSlides;
                    showSlide(nextIndex);
                }, 5000);
                
                // Event listeners for manual navigation
                prevButton.addEventListener('click', () => {
                    clearInterval(slideInterval);
                    let prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
                    showSlide(prevIndex);
                    
                    // Restart auto-advance
                    slideInterval = setInterval(() => {
                        let nextIndex = (currentSlide + 1) % totalSlides;
                        showSlide(nextIndex);
                    }, 5000);
                });
                
                nextButton.addEventListener('click', () => {
                    clearInterval(slideInterval);
                    let nextIndex = (currentSlide + 1) % totalSlides;
                    showSlide(nextIndex);
                    
                    // Restart auto-advance
                    slideInterval = setInterval(() => {
                        let nextIndex = (currentSlide + 1) % totalSlides;
                        showSlide(nextIndex);
                    }, 5000);
                });
                
                // Click on pagination dots
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        clearInterval(slideInterval);
                        showSlide(index);
                        
                        // Restart auto-advance
                        slideInterval = setInterval(() => {
                            let nextIndex = (currentSlide + 1) % totalSlides;
                            showSlide(nextIndex);
                        }, 5000);
                    });
                });
            });
        </script>
    </body>
</html>
