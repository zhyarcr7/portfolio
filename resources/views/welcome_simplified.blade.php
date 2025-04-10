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
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col w-full">
        <div class="w-full max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold mb-4">Welcome</h1>
            <p class="mb-4">This is a simplified version of the welcome page to fix syntax errors.</p>
            
            @if (Route::has('login'))
                <div class="flex space-x-4 mb-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            
            @php
                $activeCVFile = \App\Models\CVFile::where('is_active', true)->first();
            @endphp
            
            @if($activeCVFile)
                                            <div class="mb-4">
                    <a href="{{ asset('storage/' . $activeCVFile->file_path) }}" download="{{ $activeCVFile->original_filename }}" class="bg-green-500 text-white px-4 py-2 rounded inline-flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Download CV
                    </a>
                </div>
                                @else
                <div class="mb-4 p-4 bg-gray-100 rounded">
                    <p>No active CV file available.</p>
                </div>
            @endif
        </div>
    </body>
</html>
