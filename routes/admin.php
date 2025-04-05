<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ComingSoonController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::prefix('about')->group(function () {
        Route::get('/edit', [AboutController::class, 'edit'])->name('about.edit');
        Route::put('/update', [AboutController::class, 'update'])->name('about.update');
    });

    Route::resource('blogs', BlogController::class);
    Route::resource('works', WorkController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('hero-slides', HeroSlideController::class);
    Route::resource('navigation', NavigationController::class);
    Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
    
    Route::prefix('location')->group(function () {
        Route::get('/edit', [LocationController::class, 'edit'])->name('location.edit');
        Route::put('/update', [LocationController::class, 'update'])->name('location.update');
    });

    Route::resource('coming-soon', ComingSoonController::class);
}); 