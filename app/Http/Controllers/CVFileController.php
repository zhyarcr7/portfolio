<?php

namespace App\Http\Controllers;

use App\Models\CVFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CVFileController extends Controller
{
    /**
     * Display a listing of CV files.
     */
    public function index()
    {
        $cvFiles = CVFile::orderBy('created_at', 'desc')->get();
        return view('cv-files.index', compact('cvFiles'));
    }

    /**
     * Show the form for creating a new CV file.
     */
    public function create()
    {
        return view('cv-files.create');
    }

    /**
     * Store a newly created CV file in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            // Create the directory if it doesn't exist
            Storage::makeDirectory('public/cv_files');
            
            $file = $request->file('file_path');
            $originalFilename = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            
            // Generate unique filename
            $filename = time() . '_' . $originalFilename;
            
            // Store the file
            $path = $file->storeAs('public/cv_files', $filename);
            
            // Also save a copy as zhyar_cv.pdf in the public directory if it's active
            if ($request->has('is_active') && $request->is_active) {
                $file->storeAs('public', 'zhyar_cv.pdf');
                
                // Set all other files as inactive
                CVFile::where('id', '!=', 0)->update(['is_active' => false]);
            }
            
            // Create the CVFile record
            $cvFile = CVFile::create([
                'filename' => $filename,
                'original_filename' => $originalFilename,
                'file_path' => 'cv_files/' . $filename,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
            ]);
            
            return redirect()->route('cv-files.index')
                ->with('success', 'CV file uploaded successfully.');
        }
        
        return redirect()->back()
            ->with('error', 'No file was uploaded.')
            ->withInput();
    }

    /**
     * Display the specified CV file.
     */
    public function show(CVFile $cvFile)
    {
        return view('cv-files.show', compact('cvFile'));
    }

    /**
     * Show the form for editing the specified CV file.
     */
    public function edit(CVFile $cvFile)
    {
        return view('cv-files.edit', compact('cvFile'));
    }

    /**
     * Update the specified CV file in storage.
     */
    public function update(Request $request, CVFile $cvFile)
    {
        // Validate the request
        $validated = $request->validate([
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        // Handle file upload if a new file was provided
        if ($request->hasFile('file_path')) {
            // Delete old file if it exists
            if ($cvFile->file_path && Storage::exists('public/' . $cvFile->file_path)) {
                Storage::delete('public/' . $cvFile->file_path);
            }
            
            $file = $request->file('file_path');
            $originalFilename = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            
            // Generate unique filename
            $filename = time() . '_' . $originalFilename;
            
            // Store the file
            $path = $file->storeAs('public/cv_files', $filename);
            
            // Update file-related fields
            $cvFile->filename = $filename;
            $cvFile->original_filename = $originalFilename;
            $cvFile->file_path = 'cv_files/' . $filename;
            $cvFile->file_type = $fileType;
            $cvFile->file_size = $fileSize;
        }
        
        // Update other fields
        $cvFile->description = $request->description;
        $cvFile->is_active = $request->has('is_active');
        $cvFile->save();
        
        // If this file is now active, set all others as inactive
        if ($cvFile->is_active) {
            CVFile::where('id', '!=', $cvFile->id)->update(['is_active' => false]);
            
            // Also copy this file as zhyar_cv.pdf
            if (Storage::exists('public/' . $cvFile->file_path)) {
                Storage::copy('public/' . $cvFile->file_path, 'public/zhyar_cv.pdf');
            }
        }
        
        return redirect()->route('cv-files.index')
            ->with('success', 'CV file updated successfully.');
    }

    /**
     * Remove the specified CV file from storage.
     */
    public function destroy(CVFile $cvFile)
    {
        // Delete the file if it exists
        if ($cvFile->file_path && Storage::exists('public/' . $cvFile->file_path)) {
            Storage::delete('public/' . $cvFile->file_path);
        }
        
        // Delete the record
        $cvFile->delete();
        
        return redirect()->route('cv-files.index')
            ->with('success', 'CV file deleted successfully.');
    }
    
    /**
     * Set a CV file as active.
     */
    public function setActive(CVFile $cvFile)
    {
        // Set all other files as inactive
        CVFile::where('id', '!=', $cvFile->id)->update(['is_active' => false]);
        
        // Set this file as active
        $cvFile->is_active = true;
        $cvFile->save();
        
        // Copy this file as zhyar_cv.pdf
        if ($cvFile->file_path && Storage::exists('public/' . $cvFile->file_path)) {
            Storage::copy('public/' . $cvFile->file_path, 'public/zhyar_cv.pdf');
        }
        
        return redirect()->route('cv-files.index')
            ->with('success', 'CV file set as active.');
    }
    
    /**
     * Simple API to upload CV file.
     */
    public function apiUpload(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'file_path' => 'required|file|mimes:pdf,doc,docx|max:10240',
                'description' => 'nullable|string|max:1000',
                'is_active' => 'boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            // Handle file upload
            if ($request->hasFile('file_path')) {
                // Create the directory if it doesn't exist
                Storage::makeDirectory('public/cv_files');
                
                $file = $request->file('file_path');
                $originalFilename = $file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();
                
                // Generate unique filename
                $filename = time() . '_' . $originalFilename;
                
                // Store the file
                $path = $file->storeAs('public/cv_files', $filename);
                
                // Set active status
                $isActive = $request->has('is_active') ? $request->is_active : true;
                
                // If active, update other files and copy as zhyar_cv.pdf
                if ($isActive) {
                    CVFile::where('id', '!=', 0)->update(['is_active' => false]);
                    $file->storeAs('public', 'zhyar_cv.pdf');
                }
                
                // Create the CVFile record
                $cvFile = CVFile::create([
                    'filename' => $filename,
                    'original_filename' => $originalFilename,
                    'file_path' => 'cv_files/' . $filename,
                    'file_type' => $fileType,
                    'file_size' => $fileSize,
                    'description' => $request->description,
                    'is_active' => $isActive,
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'CV file uploaded successfully.',
                    'data' => [
                        'id' => $cvFile->id,
                        'filename' => $cvFile->filename,
                        'file_url' => asset('storage/' . $cvFile->file_path),
                        'public_url' => asset('storage/zhyar_cv.pdf'),
                        'is_active' => $cvFile->is_active,
                    ]
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No file was uploaded.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading CV file: ' . $e->getMessage()
            ], 500);
        }
    }
}
