<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZhyarCV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ZhyarCVController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cvs = ZhyarCV::all();
            return view('admin.zhyar-cv.index', compact('cvs'));
        } catch (\Exception $e) {
            return 'Error in index method: ' . $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.zhyar-cv.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('CV Store Request', ['request' => $request->all()]);
        
        // Validate the form data
        $validatedData = $request->validate([
            'professional_title' => 'required|string|max:255',
            'content' => 'required|string',
            'skills' => 'nullable|json',
            'education' => 'nullable|json',
            'work_experience' => 'nullable|json',
            'certifications' => 'nullable|json',
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);
        
        // Create a new ZhyarCV instance
        $zhyarCV = new ZhyarCV;
        $zhyarCV->professional_title = $validatedData['professional_title'];
        $zhyarCV->content = $validatedData['content'];
        $zhyarCV->skills = $validatedData['skills'] ?? null;
        $zhyarCV->education = $validatedData['education'] ?? null;
        $zhyarCV->work_experience = $validatedData['work_experience'] ?? null;
        $zhyarCV->certifications = $validatedData['certifications'] ?? null;
        $zhyarCV->title = $validatedData['title'];
        $zhyarCV->is_active = $request->has('is_active');
        
        // Handle file upload
        if ($request->hasFile('file_path')) {
            \Log::info('CV file detected', ['file' => $request->file('file_path')->getClientOriginalName()]);
            
            // Create the directory if it doesn't exist
            Storage::makeDirectory('public/cv_files');
            
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in the public/cv_files directory
            $path = $file->storeAs('public/cv_files', $fileName);
            
            // Store just the filename
            $zhyarCV->file_path = $fileName;
            
            \Log::info('CV file saved', ['filename' => $fileName, 'path' => $path]);
            
            // Also save as zhyar_cv.pdf in the public directory
            if (in_array($file->getClientOriginalExtension(), ['pdf', 'doc', 'docx'])) {
                $file->storeAs('public', 'zhyar_cv.pdf');
            }
        } elseif ($request->has('direct_file_path') && !empty($request->direct_file_path)) {
            // If direct file path is provided, use that
            $zhyarCV->file_path = $request->direct_file_path;
            \Log::info('Direct file path used', ['path' => $request->direct_file_path]);
        }
        
        // If this is active, make others inactive
        if ($zhyarCV->is_active) {
            ZhyarCV::where('id', '!=', $zhyarCV->id)->update(['is_active' => false]);
        }
        
        // Save the ZhyarCV
        $result = $zhyarCV->save();
        \Log::info('CV saved result', ['success' => $result, 'cv' => $zhyarCV->toArray()]);
        
        // Redirect to the index page with a success message
        return redirect()->route('admin.zhyar-cv.index')->with('success', 'CV created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ZhyarCV $zhyarCv)
    {
        return view('admin.zhyar-cv.show', compact('zhyarCv'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ZhyarCV $zhyarCv)
    {
        return view('admin.zhyar-cv.edit', compact('zhyarCv'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ZhyarCV $zhyarCV)
    {
        \Log::info('CV Update Request', ['request' => $request->all()]);
        
        // Validate the form data
        $validatedData = $request->validate([
            'professional_title' => 'required|string|max:255',
            'content' => 'required|string',
            'skills' => 'nullable|json',
            'education' => 'nullable|json',
            'work_experience' => 'nullable|json',
            'certifications' => 'nullable|json',
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);
        
        // Update the ZhyarCV instance
        $zhyarCV->professional_title = $validatedData['professional_title'];
        $zhyarCV->content = $validatedData['content'];
        $zhyarCV->skills = $validatedData['skills'] ?? $zhyarCV->skills;
        $zhyarCV->education = $validatedData['education'] ?? $zhyarCV->education;
        $zhyarCV->work_experience = $validatedData['work_experience'] ?? $zhyarCV->work_experience;
        $zhyarCV->certifications = $validatedData['certifications'] ?? $zhyarCV->certifications;
        $zhyarCV->title = $validatedData['title'];
        $zhyarCV->is_active = $request->has('is_active');
        
        // Handle file upload
        if ($request->hasFile('file_path')) {
            \Log::info('CV file detected', ['file' => $request->file('file_path')->getClientOriginalName()]);
            
            // Create the directory if it doesn't exist
            Storage::makeDirectory('public/cv_files');
            
            // Delete the old file if it exists
            if ($zhyarCV->file_path && Storage::exists('public/cv_files/' . $zhyarCV->file_path)) {
                Storage::delete('public/cv_files/' . $zhyarCV->file_path);
            }
            
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in the public/cv_files directory
            $path = $file->storeAs('public/cv_files', $fileName);
            
            // Store just the filename
            $zhyarCV->file_path = $fileName;
            
            \Log::info('CV file saved', ['filename' => $fileName, 'path' => $path]);
            
            // Also save as zhyar_cv.pdf in the public directory
            if (in_array($file->getClientOriginalExtension(), ['pdf', 'doc', 'docx'])) {
                $file->storeAs('public', 'zhyar_cv.pdf');
            }
        } elseif ($request->has('direct_file_path') && !empty($request->direct_file_path)) {
            // If direct file path is provided, use that
            $zhyarCV->file_path = $request->direct_file_path;
            \Log::info('Direct file path used', ['path' => $request->direct_file_path]);
        }
        
        // If this is active, make others inactive
        if ($zhyarCV->is_active) {
            ZhyarCV::where('id', '!=', $zhyarCV->id)->update(['is_active' => false]);
        }
        
        // Save the ZhyarCV
        $result = $zhyarCV->save();
        \Log::info('CV saved result', ['success' => $result, 'cv' => $zhyarCV->toArray()]);
        
        // Redirect to the index page with a success message
        return redirect()->route('admin.zhyar-cv.index')->with('success', 'CV updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZhyarCV $zhyarCv)
    {
        // Delete CV file if exists
            if ($zhyarCv->file_path) {
            Storage::delete('public/cv_files/' . $zhyarCv->file_path);
        }
        
        $zhyarCv->delete();
        
        return redirect()->route('admin.zhyar-cv.index')
            ->with('success', 'CV deleted successfully');
    }
    
    /**
     * Toggle active status
     */
    public function toggleActive(ZhyarCV $zhyarCv)
    {
        $zhyarCv->update([
            'is_active' => !$zhyarCv->is_active
        ]);
        
        return redirect()->route('admin.zhyar-cv.index')
            ->with('success', 'CV status updated successfully');
    }
    
    /**
     * Process JSON field from textarea
     */
    private function processJsonField($jsonString)
    {
        if (empty($jsonString)) {
            return null;
        }
        
        try {
            return json_decode($jsonString, true);
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Simple test method for troubleshooting
     */
    public function test()
    {
        return 'ZhyarCVController is working';
    }
    
    /**
     * Simple test with a minimal view
     */
    public function testView()
    {
        $data = ['message' => 'This is a test view'];
        return view('welcome', $data);
    }

    /**
     * Test index view with minimal data
     */
    public function testIndexView()
    {
        try {
            $cv = new ZhyarCV();
            $cv->id = 1;
            $cv->professional_title = 'Test Title';
            $cv->is_active = true;
            $cv->updated_at = now();
            
            $cvs = collect([$cv]);
            
            return view('admin.zhyar-cv.index', compact('cvs'));
        } catch (\Exception $e) {
            return 'Error in testIndexView: ' . $e->getMessage();
        }
    }

    /**
     * Upload CV directly
     */
    public function uploadDirectCV(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'file_path' => 'required|file|mimes:pdf,doc,docx|max:10240',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                
                // Create directory if it doesn't exist
                Storage::makeDirectory('public/cv_files');
                
                // Save the file with its original name to cv_files directory
                $originalFileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/cv_files', $originalFileName);
                
                // Also save as zhyar_cv.pdf in the public directory
                $file->storeAs('public', 'zhyar_cv.pdf');
                
                // Try to update the active CV record
                $activeCV = ZhyarCV::where('is_active', true)->first();
                if ($activeCV) {
                    $activeCV->file_path = $originalFileName;
                    $activeCV->save();
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'CV uploaded successfully!',
                    'file_url' => asset('storage/zhyar_cv.pdf'),
                    'file_path' => $originalFileName,
                    'original_filename' => $originalFileName
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file was provided'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading CV: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Diagnostic method to check all CV data in the database
     */
    public function checkDatabaseCVs()
    {
        try {
            // Get all CV records
            $allCVs = ZhyarCV::all();
            
            $results = [
                'total_records' => $allCVs->count(),
                'has_active_cv' => false,
                'records' => []
            ];

            // Check each CV record
            foreach ($allCVs as $cv) {
                $cvData = [
                    'id' => $cv->id,
                    'professional_title' => $cv->professional_title,
                    'summary' => substr($cv->summary, 0, 100) . '...',
                    'file_path' => $cv->file_path,
                    'is_active' => $cv->is_active,
                    'created_at' => $cv->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $cv->updated_at->format('Y-m-d H:i:s'),
                    'has_skills' => !empty($cv->skills),
                    'has_education' => !empty($cv->education),
                    'has_work_experience' => !empty($cv->work_experience),
                    'has_certifications' => !empty($cv->certifications),
                ];
                
                // Check if file exists
                if ($cv->file_path) {
                    $cvData['file_exists_in_cv_files'] = Storage::exists('public/cv_files/' . $cv->file_path);
                    $cvData['file_exists_in_public'] = Storage::exists('public/' . $cv->file_path);
                    $cvData['file_url'] = asset('storage/cv_files/' . $cv->file_path);
                    $cvData['direct_file_url'] = asset('storage/' . $cv->file_path);
                }
                
                if ($cv->is_active) {
                    $results['has_active_cv'] = true;
                    $results['active_cv_id'] = $cv->id;
                }
                
                $results['records'][] = $cvData;
            }
            
            // Check if zhyar_cv.pdf exists directly in public storage
            $results['zhyar_cv_exists'] = Storage::exists('public/zhyar_cv.pdf');
            $results['zhyar_cv_url'] = asset('storage/zhyar_cv.pdf');
            
            // Check storage link
            $results['storage_link_exists'] = file_exists(public_path('storage'));
            
            return view('admin.zhyar-cv.database-check', compact('results'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error checking database: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Fix the database record for CV files
     */
    public function fixDatabase(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'active_cv_id' => 'required|exists:zhyar_c_v_s,id',
                'cv_filename' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            // Get the CV record
            $cv = ZhyarCV::find($request->active_cv_id);
            
            if (!$cv) {
                return response()->json([
                    'success' => false,
                    'message' => 'CV record not found'
                ], 404);
            }
            
            // Update the CV file field
            $cv->file_path = $request->cv_filename;
            $cv->save();
            
            // Set other CVs as inactive if needed
            if ($cv->is_active) {
                ZhyarCV::where('id', '!=', $cv->id)
                    ->update(['is_active' => false]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'CV database record updated successfully. File now set to: ' . $request->cv_filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating database: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test CV upload functionality
     */
    public function testCVUpload()
    {
        try {
            // First, check if we have any active CVs
            $activeCV = ZhyarCV::where('is_active', true)->first();
            
            // If no active CV exists, create one for testing
            if (!$activeCV) {
                $activeCV = new ZhyarCV();
                $activeCV->title = 'Test CV';
                $activeCV->professional_title = 'Test Professional Title';
                $activeCV->content = 'Test content for CV';
                $activeCV->is_active = true;
                $activeCV->save();
            }
            
            // Create directories if they don't exist
            Storage::makeDirectory('public/cv_files');
            
            // Create a test PDF file directly in storage
            $fileContent = "This is a test PDF file for CV upload testing";
            Storage::put('public/test_cv.pdf', $fileContent);
            
            // Test file upload to cv_files directory
            $fileName = 'test_cv_' . time() . '.pdf';
            $testCopied = Storage::copy('public/test_cv.pdf', 'public/cv_files/' . $fileName);
            
            // Test file upload to public directory as zhyar_cv.pdf
            $publicCopied = Storage::copy('public/test_cv.pdf', 'public/zhyar_cv.pdf');
            
            // Update the active CV record
            $activeCV->file_path = $fileName;
            $dbUpdated = $activeCV->save();
            
            // Check if files exist in the correct locations
            $fileInCvFiles = Storage::exists('public/cv_files/' . $fileName);
            $fileInPublic = Storage::exists('public/zhyar_cv.pdf');
            
            // Get storage paths for debugging
            $storagePath = storage_path();
            $publicPath = public_path('storage');
            $cvFilesPath = storage_path('app/public/cv_files');
            
            // Return test results
            return response()->json([
                'success' => true,
                'message' => 'CV upload test completed',
                'test_results' => [
                    'active_cv_id' => $activeCV->id,
                    'test_file_created' => Storage::exists('public/test_cv.pdf'),
                    'test_file_copied_to_cv_files' => $testCopied && $fileInCvFiles,
                    'test_file_copied_to_public' => $publicCopied && $fileInPublic,
                    'database_updated' => $dbUpdated,
                    'file_path_in_db' => $activeCV->file_path,
                    'paths' => [
                        'storage_path' => $storagePath,
                        'public_path' => $publicPath,
                        'cv_files_path' => $cvFilesPath,
                        'cv_files_exists' => is_dir($cvFilesPath)
                    ],
                    'file_urls' => [
                        'cv_files_url' => asset('storage/cv_files/' . $fileName),
                        'public_url' => asset('storage/zhyar_cv.pdf')
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error in CV upload test: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Test the CV download functionality
     */
    public function testCVDownload()
    {
        try {
            // Get the active CV
            $activeCV = ZhyarCV::where('is_active', true)->first();
            
            // Check if we have an active CV
            if (!$activeCV) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active CV found. Please run the test-cv-upload test first.'
                ], 404);
            }
            
            // Now let's check if the zhyar_cv.pdf exists in the public directory
            $publicCVExists = Storage::exists('public/zhyar_cv.pdf');
            
            // Let's check if the specific CV file exists
            $cvFileExists = false;
            if ($activeCV->file_path) {
                $cvFileExists = Storage::exists('public/cv_files/' . $activeCV->file_path);
            }
            
            // Check accessibility via web URLs
            $publicURL = asset('storage/zhyar_cv.pdf');
            $cvFilesURL = $activeCV->file_path ? asset('storage/cv_files/' . $activeCV->file_path) : null;
            
            // Check welcome page download link
            $welcomeURL = url('/');
            
            // Return results
            return response()->json([
                'success' => true,
                'message' => 'CV download test completed',
                'test_results' => [
                    'active_cv' => [
                        'id' => $activeCV->id,
                        'title' => $activeCV->title,
                        'file_path' => $activeCV->file_path
                    ],
                    'storage_checks' => [
                        'public_cv_exists' => $publicCVExists,
                        'cv_file_exists' => $cvFileExists
                    ],
                    'urls' => [
                        'public_url' => $publicURL,
                        'cv_files_url' => $cvFilesURL,
                        'welcome_page' => $welcomeURL,
                        'public_download_test' => $publicURL . '?test=' . time(),
                        'cv_file_download_test' => $cvFilesURL ? $cvFilesURL . '?test=' . time() : null
                    ],
                    'instructions' => [
                        'test_download' => 'Visit ' . $publicURL . ' in your browser to test downloading the CV directly',
                        'test_welcome_page' => 'Visit ' . $welcomeURL . ' and click on the "Download Full CV" button to test the download functionality'
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error in CV download test: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
} 