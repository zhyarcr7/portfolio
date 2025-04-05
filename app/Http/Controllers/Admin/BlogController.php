<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'nullable|string|max:100',
            'summary' => 'nullable|string',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            try {
                // Make sure the blogs directory exists
                Storage::disk('public')->makeDirectory('blogs');
                
                // Store the image
                $path = $request->file('image')->store('blogs', 'public');
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return redirect()->back()->withInput()
                    ->with('error', 'Error uploading image: ' . $e->getMessage());
            }
        }

        $validated['is_published'] = $request->has('is_published');
        $validated['featured'] = $request->has('featured');

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'nullable|string|max:100',
            'summary' => 'nullable|string',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            try {
                // Delete old image
                if ($blog->image) {
                    Storage::disk('public')->delete($blog->image);
                }
                
                // Make sure the blogs directory exists
                Storage::disk('public')->makeDirectory('blogs');
                
                // Store the new image
                $path = $request->file('image')->store('blogs', 'public');
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return redirect()->back()->withInput()
                    ->with('error', 'Error uploading image: ' . $e->getMessage());
            }
        }

        $validated['is_published'] = $request->has('is_published');
        $validated['featured'] = $request->has('featured');

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }
} 