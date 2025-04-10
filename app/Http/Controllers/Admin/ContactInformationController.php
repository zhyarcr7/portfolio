<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInformation;
use Illuminate\Http\Request;

class ContactInformationController extends Controller
{
    /**
     * Display a listing of the contact information.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactInfo = ContactInformation::first() ?? new ContactInformation();
        return view('admin.contact-information.index', compact('contactInfo'));
    }

    /**
     * Show the form for editing the contact information.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $contactInfo = ContactInformation::first() ?? new ContactInformation();
        return view('admin.contact-information.edit', compact('contactInfo'));
    }

    /**
     * Update the contact information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'map_url' => 'nullable|string|max:1000',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:255',
                'website' => 'nullable|string|max:255',
                'facebook' => 'nullable|string|max:255',
                'twitter' => 'nullable|string|max:255',
                'instagram' => 'nullable|string|max:255',
                'linkedin' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'opening_hours' => 'nullable|string',
                'is_active' => 'nullable',
            ]);

            // Properly convert is_active to boolean value
            $validated['is_active'] = $request->has('is_active') ? true : false;
            
            // Direct database approach to ensure proper update
            $contactInfo = \App\Models\ContactInformation::first();
            
            if ($contactInfo) {
                // Update existing record
                $contactInfo->update($validated);
            } else {
                // Create new record
                \App\Models\ContactInformation::create($validated);
            }

            return redirect()->route('admin.contact-information.index')
                ->with('success', 'Contact information updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating contact information: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating contact information: ' . $e->getMessage())
                ->withInput();
        }
    }
}
