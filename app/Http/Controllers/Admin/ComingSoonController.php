<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComingSoon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComingSoonController extends Controller
{
    public function index()
    {
        $items = ComingSoon::latest()->paginate(10);
        return view('admin.coming-soon.index', compact('items'));
    }

    public function create()
    {
        return view('admin.coming-soon.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'launch_date' => 'required|date',
            'is_active' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('coming-soon', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        ComingSoon::create($validated);

        return redirect()->route('admin.coming-soon.index')
            ->with('success', 'Coming soon item created successfully.');
    }

    public function edit(ComingSoon $comingSoon)
    {
        return view('admin.coming-soon.edit', compact('comingSoon'));
    }

    public function update(Request $request, ComingSoon $comingSoon)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'launch_date' => 'required|date',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($comingSoon->image) {
                Storage::disk('public')->delete($comingSoon->image);
            }
            
            $imagePath = $request->file('image')->store('coming-soon', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        $comingSoon->update($validated);

        return redirect()->route('admin.coming-soon.index')
            ->with('success', 'Coming soon item updated successfully.');
    }

    public function destroy(ComingSoon $comingSoon)
    {
        if ($comingSoon->image) {
            Storage::disk('public')->delete($comingSoon->image);
        }

        $comingSoon->delete();

        return redirect()->route('admin.coming-soon.index')
            ->with('success', 'Coming soon item deleted successfully.');
    }
} 