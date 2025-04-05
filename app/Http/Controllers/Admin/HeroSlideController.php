<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HeroSlideController extends Controller
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = HeroSlide::orderBy('order')->paginate(10);
        return view('admin.hero-slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Make sure the storage directory exists
            $directory = storage_path('app/public/hero-slides');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Make sure the public directory exists too
            $publicDir = public_path('storage/hero-slides');
            if (!file_exists($publicDir)) {
                mkdir($publicDir, 0755, true);
            }
            
            // Resize the image using Intervention Image
            $image = $request->file('image');
            $img = $this->imageManager->read($image->getRealPath());
            $img->scale(width: 1920);
            
            // Generate a unique filename
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Save directly to the storage directory
            $img->encode(new \Intervention\Image\Encoders\JpegEncoder())
               ->save(storage_path('app/public/hero-slides/' . $filename));
            
            // Copy the file to the public directory as well for extra assurance
            copy(
                storage_path('app/public/hero-slides/' . $filename),
                public_path('storage/hero-slides/' . $filename)
            );
            
            // Set the correct path for database
            $storagePath = 'hero-slides/' . $filename;
            
            HeroSlide::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'bgImage' => $storagePath,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'order' => $request->order,
                'is_active' => $request->has('is_active'),
                'ctaText' => $request->button_text ?: 'Learn More',
                'ctaLink' => $request->button_link ?: '#',
            ]);

            return redirect()->route('admin.hero-slides.index')
                ->with('success', 'Hero slide created successfully.');
        }

        return back()->with('error', 'Image upload failed.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
            'ctaText' => $request->button_text ?: 'Learn More',
            'ctaLink' => $request->button_link ?: '#',
        ];

        if ($request->hasFile('image')) {
            // Make sure the storage directory exists
            $directory = storage_path('app/public/hero-slides');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Make sure the public directory exists too
            $publicDir = public_path('storage/hero-slides');
            if (!file_exists($publicDir)) {
                mkdir($publicDir, 0755, true);
            }
            
            // Delete old image if exists
            if ($heroSlide->bgImage && Storage::exists('public/' . $heroSlide->bgImage)) {
                Storage::delete('public/' . $heroSlide->bgImage);
            }

            // Resize the image using Intervention Image
            $image = $request->file('image');
            $img = $this->imageManager->read($image->getRealPath());
            $img->scale(width: 1920);
            
            // Generate a unique filename
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Save directly to the storage directory
            $img->encode(new \Intervention\Image\Encoders\JpegEncoder())
               ->save(storage_path('app/public/hero-slides/' . $filename));
            
            // Copy the file to the public directory as well for extra assurance
            copy(
                storage_path('app/public/hero-slides/' . $filename),
                public_path('storage/hero-slides/' . $filename)
            );
            
            // Set the correct path for database
            $data['bgImage'] = 'hero-slides/' . $filename;
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSlide $heroSlide)
    {
        // Delete image if exists
        if ($heroSlide->bgImage && Storage::exists('public/' . $heroSlide->bgImage)) {
            Storage::delete('public/' . $heroSlide->bgImage);
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide deleted successfully.');
    }

    /**
     * Test image upload directly.
     */
    public function testUpload()
    {
        // Create a test image
        $img = $this->imageManager->create(800, 600)->fill('#0066cc');
        
        // Create a temporary file with the image
        $tempFile = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($tempFile, $img->encode(new \Intervention\Image\Encoders\JpegEncoder())->toString());
        
        // Let Laravel handle the file storage with its own naming convention
        $path = Storage::putFile('public/hero-slides', $tempFile);
        
        // Clean up the temp file
        @unlink($tempFile);
        
        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => Storage::url($path)
        ]);
    }
} 