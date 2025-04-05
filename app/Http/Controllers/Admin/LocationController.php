<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function edit()
    {
        // Get the first location or create a new one if none exists
        $location = Location::first() ?? new Location();
        
        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'address' => 'required|string|max:255',
                'map_url' => 'required|string|max:191',
                'contact_email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
            ]);
            
            // Get the first location or create a new one
            $location = Location::first();
            
            if (!$location) {
                $location = new Location();
            }
            
            // Update the location
            $location->fill($validated);
            $location->save();
            
            return redirect()->route('admin.location.edit')
                ->with('success', 'Location information updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating location: ' . $e->getMessage());
            
            return redirect()->route('admin.location.edit')
                ->with('error', 'An error occurred while updating the location information.');
        }
    }
} 