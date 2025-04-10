<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialLinks = SocialLink::orderBy('order', 'asc')->get();
        return view('admin.social-links.index', compact('socialLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.social-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|string|url|max:255',
            'icon_class' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Set default values
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = isset($validated['is_active']) ? true : false;

        SocialLink::create($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social media link created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $socialLink = SocialLink::findOrFail($id);
        return view('admin.social-links.edit', compact('socialLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $socialLink = SocialLink::findOrFail($id);

        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|string|url|max:255',
            'icon_class' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Set default values
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = isset($validated['is_active']) ? true : false;

        $socialLink->update($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social media link updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $socialLink = SocialLink::findOrFail($id);
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social media link deleted successfully.');
    }
}
