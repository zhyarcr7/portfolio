<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\ComingSoonController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\ZhyarCVController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CVFileController;
use App\Http\Controllers\Admin\SocialLinkController;
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
use App\Http\Controllers\TestPusherController;
use App\Http\Controllers\PusherTestController;
use App\Http\Controllers\Admin\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page route - using the proper controller
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

// Contact form submission
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// User authentication routes with custom URL prefix
Route::group(['prefix' => 'user', 'namespace' => 'App\Http\Controllers\Auth', 'as' => 'user.'], function () {
    Route::get('/login', [App\Http\Controllers\Auth\UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\UserAuthController::class, 'login']);
    
    Route::get('/register', [App\Http\Controllers\Auth\UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\UserAuthController::class, 'register']);
    
    Route::post('/logout', [App\Http\Controllers\Auth\UserAuthController::class, 'logout'])->name('logout');
    
    Route::get('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
});

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
    
    // Add contact information data
    try {
        $contactInfo = \App\Models\ContactInformation::first();
        $counts['contactInfo'] = $contactInfo ? 1 : 0;
        $contactActive = $contactInfo && $contactInfo->is_active ? true : false;
    } catch (\Exception $e) {
        $counts['contactInfo'] = 0;
        $contactActive = false;
    }
    
    return view('dashboard', compact('counts', 'contactActive'));
})->middleware(['auth', CheckUserRole::class])->name('dashboard');

// Admin authentication routes (should be before admin routes group)
Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.'], function () {
    Route::get('/portal', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/portal', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

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
    
    // Social Links Routes
    Route::resource('social-links', SocialLinkController::class);
    
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
    Route::delete('zhyar-cv/{zhyarCv}', [ZhyarCVController::class, 'destroy'])->name('zhyar-cv.destroy');
    
    // Location Routes
    Route::get('location/edit', [LocationController::class, 'edit'])->name('location.edit');
    Route::put('location/update', [LocationController::class, 'update'])->name('location.update');
    
    // Contact Information Routes
    Route::get('contact-information', [App\Http\Controllers\Admin\ContactInformationController::class, 'index'])->name('contact-information.index');
    Route::get('contact-information/edit', [App\Http\Controllers\Admin\ContactInformationController::class, 'edit'])->name('contact-information.edit');
    Route::put('contact-information/update', [App\Http\Controllers\Admin\ContactInformationController::class, 'update'])->name('contact-information.update');

    // Direct CV upload route
    Route::post('/cv/upload-direct', [App\Http\Controllers\Admin\ZhyarCVController::class, 'uploadDirectCV'])->name('cv.upload-direct');
    
    // CV database diagnostic route
    Route::get('/cv/database-check', [App\Http\Controllers\Admin\ZhyarCVController::class, 'checkDatabaseCVs'])->name('cv.database-check');
    
    // CV database fix route
    Route::post('/cv/fix-database', [App\Http\Controllers\Admin\ZhyarCVController::class, 'fixDatabase'])->name('cv.fix-database');

    // CV Files Routes
    Route::resource('cv-files', CVFileController::class);
    Route::post('/cv-files/{cvFile}/set-active', [CVFileController::class, 'setActive'])->name('cv-files.set-active');
    Route::post('/api/cv-files/upload', [CVFileController::class, 'apiUpload'])->name('cv-files.api-upload');
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
    
    // Add route for getting conversations list
    Route::get('/chat/conversations', [App\Http\Controllers\ChatController::class, 'getConversations'])->name('chat.getConversations');
    
    // Routes with parameters need to come after static routes
    Route::get('/chat/poll/{conversation}/messages', [App\Http\Controllers\ChatController::class, 'pollMessages'])->name('chat.poll-messages');
    Route::get('/chat/{conversation}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/messages', [App\Http\Controllers\ChatController::class, 'storeMessage'])->name('chat.messages.store');
    Route::post('/chat/{conversation}/mark-read', [App\Http\Controllers\ChatController::class, 'markRead'])->name('chat.mark-read');
    
    // Route to create a sample conversation for testing
    Route::get('/chat/create-sample', [App\Http\Controllers\ChatController::class, 'createSampleConversation'])->name('chat.create-sample');
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

// Contact info debug route
Route::get('/debug-contact-info', function() {
    $contactInfo = \App\Models\ContactInformation::first();
    
    // Check if we have any contact info
    $allContacts = \App\Models\ContactInformation::count();
    
    // Get active contact info
    $activeContact = \App\Models\ContactInformation::where('is_active', true)->first();
    
    return [
        'total_records' => $allContacts,
        'any_exists' => $contactInfo ? true : false,
        'active_exists' => $activeContact ? true : false,
        'data' => $contactInfo,
        'schema_exists' => \Schema::hasTable('contact_information'),
        'column_has_is_active' => \Schema::hasColumn('contact_information', 'is_active'),
        'route' => route('admin.contact-information.update')
    ];
});

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

// Test Pusher route
Route::get('/test-pusher', [App\Http\Controllers\TestPusherController::class, 'test']);

// CV Test Routes
Route::get('/test-cv-upload', [App\Http\Controllers\Admin\ZhyarCVController::class, 'testCVUpload'])->name('test-cv-upload');
Route::get('/test-cv-download', [App\Http\Controllers\Admin\ZhyarCVController::class, 'testCVDownload'])->name('test-cv-download');

// Contact test route
Route::post('/test-contact-update', function(\Illuminate\Http\Request $request) {
    try {
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255'
        ]);
        
        $contactInfo = \App\Models\ContactInformation::first();
        if (!$contactInfo) {
            $contactInfo = new \App\Models\ContactInformation();
            $contactInfo->is_active = true; // Set default to true for new records
        }
        
        $contactInfo->fill($validated);
        $contactInfo->save();
        
        return redirect()->back()->with('success', 'Contact information updated via test route');
    } catch (\Exception $e) {
        \Log::error('Test contact update error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
});

// Contact fix route
Route::get('/fix-contact-info', function() {
    try {
        // Check if we have any contact records
        $contactExists = \App\Models\ContactInformation::count() > 0;
        
        if ($contactExists) {
            // Get existing record and update it
            $contactInfo = \App\Models\ContactInformation::first();
            $contactInfo->is_active = true;
            $contactInfo->save();
            
            return "Contact information fixed! Record is now active.";
        } else {
            // Create a default record
            \App\Models\ContactInformation::create([
                'email' => 'your.email@example.com',
                'phone' => '+1 234 567 8901',
                'address' => '123 Street Name',
                'city' => 'City Name',
                'country' => 'Country',
                'is_active' => true
            ]);
            return "Created default contact information!";
        }
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';

// Pusher Test Routes
Route::get('/pusher-test', [App\Http\Controllers\PusherTestController::class, 'index'])->name('pusher.test');
Route::post('/api/send-test-message', [App\Http\Controllers\PusherTestController::class, 'sendMessage'])->name('pusher.send-message');

// Test route for email sending with detailed debugging
Route::get('/test-email-debug', function () {
    $mailConfig = config('mail');
    $configOutput = "Mail Driver: " . ($mailConfig['default'] ?? $mailConfig['driver'] ?? 'unknown') . "\n";
    $configOutput .= "Mail Host: " . ($mailConfig['host'] ?? 'unknown') . "\n";
    $configOutput .= "Mail Port: " . ($mailConfig['port'] ?? 'unknown') . "\n";
    $configOutput .= "Mail From: " . ($mailConfig['from']['address'] ?? 'unknown') . "\n";
    $configOutput .= "Mail Encryption: " . ($mailConfig['encryption'] ?? 'none') . "\n";
    
    try {
        $testData = [
            'name' => 'Debug User',
            'email' => 'test@example.com',
            'subject' => 'Debug Email Test',
            'message' => 'This is a test message for debugging.'
        ];
        
        // Print full mail config for debugging
        \Illuminate\Support\Facades\Log::info('Full mail config: ', $mailConfig);
        
        // Log detail before sending
        \Illuminate\Support\Facades\Log::info('Attempting to send debug test email');
        \Illuminate\Support\Facades\Log::info($configOutput);
        
        // Try to send the email
        \Illuminate\Support\Facades\Mail::to($mailConfig['from']['address'] ?? 'your-email@example.com')->send(
            new \App\Mail\ContactFormSubmission($testData)
        );
        
        \Illuminate\Support\Facades\Log::info('Debug email send attempt completed');
        
        return "<pre>Mail Configuration:\n$configOutput\n\nTest email sent! Check logs for details.</pre>";
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Error sending debug email: ' . $e->getMessage());
        \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
        
        return "<pre>Mail Configuration:\n$configOutput\n\nError: " . $e->getMessage() . "</pre>";
    }
});

// Test route for email sending
Route::get('/test-contact-email', function () {
    $testData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Test Email',
        'message' => 'This is a test message from the contact form.'
    ];
    
    try {
        \Illuminate\Support\Facades\Mail::to(config('mail.from.address'))->send(
            new \App\Mail\ContactFormSubmission($testData)
        );
        
        return 'Test email sent successfully! Check your logs or email inbox.';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});

// Direct mail test route for debugging
Route::get('/test-raw-email', function () {
    try {
        // Log that we're attempting to send
        \Illuminate\Support\Facades\Log::info('Attempting to send raw test email via Mailtrap');
        
        // Get mail config for debugging
        $mailConfig = config('mail');
        \Illuminate\Support\Facades\Log::info('Mail config:', [
            'driver' => $mailConfig['default'] ?? $mailConfig['driver'] ?? 'unknown',
            'host' => $mailConfig['host'] ?? 'unknown',
            'port' => $mailConfig['port'] ?? 'unknown',
            'from' => $mailConfig['from']['address'] ?? 'unknown',
            'encryption' => $mailConfig['encryption'] ?? 'none'
        ]);
        
        // Send a very simple email
        \Illuminate\Support\Facades\Mail::raw('This is a test email sent at ' . now(), function($message) {
            $message->to('test@example.com');
            $message->subject('Raw Test Email');
        });
        
        \Illuminate\Support\Facades\Log::info('Raw test email sent successfully');
        
        return 'Raw test email sent! Check your Mailtrap inbox.';
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Error sending raw test email: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage();
    }
});

// Direct PHP mail test (bypasses Laravel Mail)
Route::get('/test-php-mail', function() {
    try {
        // Log attempt
        \Illuminate\Support\Facades\Log::info("Testing PHP's mail() function");
        
        // Get mail config
        $mailConfig = config('mail');
        
        // Create headers
        $to = 'test@example.com';
        $subject = 'Test Direct PHP Mail';
        $message = 'This is a test email sent using PHP\'s mail() function at ' . now();
        $headers = 'From: ' . ($mailConfig['from']['address'] ?? 'noreply@example.com') . "\r\n" .
                  'Reply-To: ' . ($mailConfig['from']['address'] ?? 'noreply@example.com') . "\r\n" .
                  'X-Mailer: PHP/' . phpversion();
                  
        // Check if PHP mail function exists and is enabled
        if (!function_exists('mail')) {
            return 'PHP mail() function is not available. Check your PHP configuration.';
        }
        
        // Try to send an email using PHP's mail() function
        $result = mail($to, $subject, $message, $headers);
        
        if ($result) {
            \Illuminate\Support\Facades\Log::info("PHP mail() was successful");
            return "PHP mail() function returned success. This doesn't guarantee delivery, check your mail logs.";
        } else {
            \Illuminate\Support\Facades\Log::error("PHP mail() failed");
            return "PHP mail() function failed. Check your PHP/server mail configuration.";
        }
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('PHP mail test error: ' . $e->getMessage());
        return "Error testing PHP mail: " . $e->getMessage();
    }
});

// Socket connection test to Mailtrap
Route::get('/test-mailtrap-connection', function() {
    try {
        $host = 'sandbox.smtp.mailtrap.io';
        $port = 2525;
        
        // Log attempt
        \Illuminate\Support\Facades\Log::info("Testing socket connection to $host:$port");
        
        // Try to open a socket connection
        $socket = @fsockopen($host, $port, $errno, $errstr, 5);
        
        if (!$socket) {
            \Illuminate\Support\Facades\Log::error("Socket error: $errstr ($errno)");
            return "Connection failed: $errstr ($errno). Your server cannot connect to Mailtrap.";
        }
        
        // Connection successful
        fclose($socket);
        \Illuminate\Support\Facades\Log::info("Socket connection to Mailtrap successful!");
        
        return "Connection to Mailtrap successful! Your server can reach Mailtrap.";
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Connection test error: ' . $e->getMessage());
        return "Error testing connection: " . $e->getMessage();
    }
});

// CSRF Token refresh route to prevent 419 errors
Route::get('/csrf-token', function() {
    return response()->json([
        'token' => csrf_token()
    ]);
});
