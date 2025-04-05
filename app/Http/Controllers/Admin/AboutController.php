<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about = AboutMe::first() ?? new AboutMe();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resumeLink' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $about = AboutMe::first() ?? new AboutMe();
        $about->title = $request->title;
        $about->subtitle = $request->subtitle;
        $about->description = $request->description;

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::delete($about->image);
            }
            $about->image = $request->file('image')->store('about', 'public');
        }

        if ($request->hasFile('resumeLink')) {
            if ($about->resumeLink) {
                Storage::delete($about->resumeLink);
            }
            $about->resumeLink = $request->file('resumeLink')->store('resume', 'public');
        }

        $about->save();

        return redirect()->route('admin.about.edit')->with('success', 'About information updated successfully.');
    }
} 