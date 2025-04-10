<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class WorkController extends Controller
{
    public function index()
    {
        try {
            $works = Work::latest()->paginate(10);
            return view('admin.works.index', compact('works'));
        } catch (\Exception $e) {
            \Log::error('Error in WorkController@index: ' . $e->getMessage());
            return view('admin.works.index', ['works' => collect()])
                ->with('error', 'An error occurred loading works. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('admin.works.create');
        } catch (\Exception $e) {
            \Log::error('Error in WorkController@create: ' . $e->getMessage());
            return redirect()->route('admin.works.index')
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'technologies' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // Single image field
                'category' => 'required|string|max:255',
                'featured' => 'boolean'
            ]);

            $work = new Work($request->except('image'));
            
            if ($request->hasFile('image')) {
                $work->image = $this->processAndStoreImage($request->file('image'));
            }
            
            $work->save();

            return redirect()->route('admin.works.index')->with('success', 'Work created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in WorkController@store: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'An error occurred saving the work. Please try again.');
        }
    }

    public function edit($id)
    {
        try {
            // Find the work by ID manually
            $work = Work::find($id);
            
            // Make sure the work exists
            if (!$work) {
                return redirect()->route('admin.works.index')
                    ->with('error', 'Work not found.');
            }
            
            // Get paginated works for the view
            $works = Work::latest()->paginate(10);
            
            return view('admin.works.edit', compact('work', 'works'));
        } catch (\Exception $e) {
            \Log::error('Error in WorkController@edit: ' . $e->getMessage());
            return redirect()->route('admin.works.index')
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the work by ID manually
            $work = Work::find($id);
            
            // Make sure the work exists
            if (!$work) {
                return redirect()->route('admin.works.index')
                    ->with('error', 'Work not found.');
            }
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'technologies' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Single image field
                'category' => 'required|string|max:255',
                'featured' => 'boolean'
            ]);

            $work->fill($request->except('image'));

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($work->image) {
                    Storage::disk('public')->delete($work->image);
                    
                    // Delete thumbnail if it exists
                    $thumbnail = $this->getThumbnailPath($work->image);
                    if ($thumbnail) {
                        Storage::disk('public')->delete($thumbnail);
                    }
                }

                $work->image = $this->processAndStoreImage($request->file('image'));
            }
            
            $work->save();

            return redirect()->route('admin.works.index')->with('success', 'Work updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in WorkController@update: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'An error occurred updating the work. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            // Find the work by ID manually
            $work = Work::find($id);
            
            // Make sure the work exists
            if (!$work) {
                return redirect()->route('admin.works.index')
                    ->with('error', 'Work not found.');
            }
            
            // Delete associated image
            if ($work->image) {
                // Delete original image
                Storage::disk('public')->delete($work->image);
                
                // Delete thumbnail if it exists
                $thumbnail = $this->getThumbnailPath($work->image);
                if ($thumbnail) {
                    Storage::disk('public')->delete($thumbnail);
                }
            }

            $work->delete();

            return redirect()->route('admin.works.index')->with('success', 'Work deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in WorkController@destroy: ' . $e->getMessage());
            return redirect()->route('admin.works.index')
                ->with('error', 'An error occurred deleting the work. Please try again.');
        }
    }
    
    /**
     * Process and store an image using Intervention Image
     * 
     * @param \Illuminate\Http\UploadedFile $image
     * @return string|null The path of the stored image relative to storage/app/public
     */
    private function processAndStoreImage($image)
    {
        try {
            // Generate a unique filename
            $filename = 'works/' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $thumbnailFilename = 'works/thumbnails/' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // Make sure the directories exist
            Storage::disk('public')->makeDirectory('works/thumbnails', 0755, true, true);
            
            // Create image manager with GD driver
            $manager = new ImageManager(new Driver());
            
            // Process and save the original image (resized to a reasonable max dimension)
            $img = $manager->read($image->getRealPath());
            
            // Resize the image while maintaining aspect ratio if it's too large
            if ($img->width() > 1920 || $img->height() > 1080) {
                $img->resize(1920, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            
            // Save the processed original image
            $img->save(storage_path('app/public/' . $filename), quality: 80); // 80% quality for compression
            
            // Create and save a thumbnail
            $thumbnail = $manager->read($image->getRealPath());
            $thumbnail->cover(300, 300); // Creates a perfect square thumbnail
            $thumbnail->save(storage_path('app/public/' . $thumbnailFilename), quality: 80);
            
            return $filename;
        } catch (\Exception $e) {
            \Log::error('Error processing image: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get the thumbnail path for a given image path
     * 
     * @param string $imagePath
     * @return string|null
     */
    private function getThumbnailPath($imagePath)
    {
        if (empty($imagePath)) {
            return null;
        }
        
        $pathInfo = pathinfo($imagePath);
        if (isset($pathInfo['dirname']) && isset($pathInfo['basename'])) {
            if ($pathInfo['dirname'] === 'works') {
                return 'works/thumbnails/' . $pathInfo['basename'];
            }
        }
        
        return null;
    }
} 