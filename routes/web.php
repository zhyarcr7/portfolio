<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\ComingSoonController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\ZhyarCVController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page route - using the proper controller
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

// Contact form submission
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

Route::get('/dashboard', function () {
    $counts = [
        'blogs' => \App\Models\Blog::count(),
        'slides' => \App\Models\HeroSlide::count(),
        'works' => \App\Models\Work::count(),
        'navigation' => \App\Models\Navigation::count(),
        'testimonials' => \App\Models\Testimonial::count(),
        'comingSoon' => \App\Models\ComingSoon::count(),
    ];
    
    try {
        $counts['zhyarCv'] = \App\Models\ZhyarCV::count();
    } catch (\Exception $e) {
        $counts['zhyarCv'] = 0;
    }
    
    return view('dashboard', compact('counts'));
})->middleware(['auth', CheckUserRole::class])->name('dashboard');

// Admin routes group with auth and admin middleware
Route::middleware(['auth', AdminMiddleware::class, CheckUserRole::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Blog Routes
    Route::resource('blogs', BlogController::class);
    
    // Work Routes
    Route::resource('works', WorkController::class);
    
    // Testimonial Routes
    Route::resource('testimonials', TestimonialController::class);
    
    // Hero Slide Routes
    Route::resource('hero-slides', HeroSlideController::class);
    
    // Coming Soon Routes
    Route::resource('coming-soon', ComingSoonController::class);
    
    // Navigation Routes
    Route::resource('navigation', NavigationController::class);
    
    // About Routes
    Route::get('about/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('about/update', [AboutController::class, 'update'])->name('about.update');
    
    // Message Routes
    Route::get('messages', function () {
        $messages = \App\Models\Message::latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    })->name('messages.index');
    
    Route::get('messages/{message}', function (\App\Models\Message $message) {
        $message->read = true;
        $message->save();
        return view('admin.messages.show', compact('message'));
    })->name('messages.show');
    
    Route::delete('messages/{message}', function (\App\Models\Message $message) {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully');
    })->name('messages.destroy');
    
    // Zhyar CV Routes - Comment out the resource route to avoid conflicts
    // Route::resource('zhyar-cv', ZhyarCVController::class);
    Route::post('zhyar-cv/{zhyarCv}/toggle-active', [ZhyarCVController::class, 'toggleActive'])->name('zhyar-cv.toggle-active');
    
    // Explicit routes for ZhyarCV
    Route::get('zhyar-cv', [ZhyarCVController::class, 'index'])->name('zhyar-cv.index');
    Route::get('zhyar-cv/create', [ZhyarCVController::class, 'create'])->name('zhyar-cv.create');
    Route::post('zhyar-cv', [ZhyarCVController::class, 'store'])->name('zhyar-cv.store');
    Route::get('zhyar-cv/{zhyarCv}', [ZhyarCVController::class, 'show'])->name('zhyar-cv.show');
    Route::get('zhyar-cv/{zhyarCv}/edit', [ZhyarCVController::class, 'edit'])->name('zhyar-cv.edit');
    Route::put('zhyar-cv/{zhyarCv}', [ZhyarCVController::class, 'update'])->name('zhyar-cv.update');
    Route::patch('zhyar-cv/{zhyarCv}', [ZhyarCVController::class, 'update'])->name('zhyar-cv.update');
    Route::delete('zhyar-cv/{zhyarCv}', [ZhyarCVController::class, 'destroy'])->name('zhyar-cv.destroy');
    
    // Location Routes
    Route::get('location/edit', [LocationController::class, 'edit'])->name('location.edit');
    Route::put('location/update', [LocationController::class, 'update'])->name('location.update');
});

Route::middleware(['auth', CheckUserRole::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chat routes
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/create', [App\Http\Controllers\ChatController::class, 'create'])->name('chat.create');
    Route::post('/chat', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    
    // Polling routes - fixed order with most specific routes first
    Route::get('/chat/unread-count', [App\Http\Controllers\ChatController::class, 'getUnreadCount'])->name('chat.unread-count');
    Route::get('/chat/poll/conversations', [App\Http\Controllers\ChatController::class, 'pollConversations'])->name('chat.poll-conversations');
    
    // Routes with parameters need to come after static routes
    Route::get('/chat/poll/{conversation}/messages', [App\Http\Controllers\ChatController::class, 'pollMessages'])->name('chat.poll-messages');
    Route::get('/chat/{conversation}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/messages', [App\Http\Controllers\ChatController::class, 'storeMessage'])->name('chat.messages.store');
    Route::post('/chat/{conversation}/mark-read', [App\Http\Controllers\ChatController::class, 'markRead'])->name('chat.mark-read');
});

// Test route for Intervention/Image
Route::get('/test-image', function () {
    try {
        $manager = new ImageManager(new Driver());
        $img = $manager->create(300, 200)->fill('#ff0000');
        return response($img->encode()->toString())->header('Content-Type', 'image/png');
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Temporary debug route
Route::get('/debug-hero-slides', function () {
    $slides = \App\Models\HeroSlide::all();
    $files = glob(public_path('storage/hero-slides/*.*'));
    
    return view('debug-hero-slides', [
        'slides' => $slides,
        'files' => $files
    ]);
});

// Image upload test route
Route::get('/test-hero-upload', [App\Http\Controllers\Admin\HeroSlideController::class, 'testUpload']);

// Direct route to ZhyarCV index for troubleshooting
Route::get('/zhyar-cv-test', function() {
    return redirect('/admin/zhyar-cv');
});

// Direct access to ZhyarCVController index (bypassing admin middleware for testing)
Route::get('/zhyar-cv-direct', [App\Http\Controllers\Admin\ZhyarCVController::class, 'index']);

// Test route that returns a view
Route::get('/zhyar-cv-test-view', [App\Http\Controllers\Admin\ZhyarCVController::class, 'testView']);

// Test index view with minimal data
Route::get('/zhyar-cv-test-index', [App\Http\Controllers\Admin\ZhyarCVController::class, 'testIndexView']);

// Direct test route to ZhyarCVController test method
Route::get('/zhyar-cv-controller-test', [App\Http\Controllers\Admin\ZhyarCVController::class, 'test']);

require __DIR__.'/auth.php';
