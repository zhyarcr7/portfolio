<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    public function index()
    {
        $works = Work::latest()->paginate(10);
        return view('admin.works.index', compact('works'));
    }

    public function create()
    {
        return view('admin.works.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|max:255',
            'featured' => 'boolean'
        ]);

        // Debug what's in the request
        \Log::info('Work create request data:', $request->all());
        
        $work = new Work($request->except('images'));
        
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('works', 'public');
            }
            $work->images = $images;
        }

        // Before saving
        \Log::info('Work about to be saved:', $work->toArray());
        
        $work->save();
        
        // After saving
        \Log::info('Work after saving:', $work->fresh()->toArray());

        return redirect()->route('admin.works.index')->with('success', 'Work created successfully.');
    }

    public function edit(Work $work)
    {
        return view('admin.works.edit', compact('work'));
    }

    public function update(Request $request, Work $work)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|max:255',
            'featured' => 'boolean'
        ]);

        // Debug what's in the request
        \Log::info('Work update request data:', $request->all());

        $work->fill($request->except('images'));

        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($work->images ?? [] as $oldImage) {
                Storage::delete($oldImage);
            }

            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('works', 'public');
            }
            $work->images = $images;
        }

        // Before saving
        \Log::info('Work about to be updated:', $work->toArray());
        
        $work->save();
        
        // After saving
        \Log::info('Work after updating:', $work->fresh()->toArray());

        return redirect()->route('admin.works.index')->with('success', 'Work updated successfully.');
    }

    public function destroy(Work $work)
    {
        // Delete associated images
        foreach ($work->images ?? [] as $image) {
            Storage::delete($image);
        }

        $work->delete();

        return redirect()->route('admin.works.index')->with('success', 'Work deleted successfully.');
    }
} 