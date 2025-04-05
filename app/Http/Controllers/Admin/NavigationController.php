<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $navigationItems = Navigation::orderBy('order')->paginate(10);
        return view('admin.navigation.index', compact('navigationItems'));
    }

    public function create()
    {
        return view('admin.navigation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'target' => 'required|string|in:_self,_blank',
            'icon' => 'nullable|string|max:255'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Navigation::create($validated);

        return redirect()->route('admin.navigation.index')
            ->with('success', 'Navigation item created successfully.');
    }

    public function edit(Navigation $navigation)
    {
        return view('admin.navigation.edit', compact('navigation'));
    }

    public function update(Request $request, Navigation $navigation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'target' => 'required|string|in:_self,_blank',
            'icon' => 'nullable|string|max:255'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $navigation->update($validated);

        return redirect()->route('admin.navigation.index')
            ->with('success', 'Navigation item updated successfully.');
    }

    public function destroy(Navigation $navigation)
    {
        $navigation->delete();

        return redirect()->route('admin.navigation.index')
            ->with('success', 'Navigation item deleted successfully.');
    }
} 