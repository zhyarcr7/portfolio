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
        $validator = Validator::make($request->all(), [
            'professional_title' => 'required|string|max:255',
            'summary' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['cv_file']);
        
        // Handle CV file upload
        if ($request->hasFile('cv_file')) {
            $cvFile = $request->file('cv_file');
            $fileName = 'zhyar_cv_' . time() . '.' . $cvFile->getClientOriginalExtension();
            $cvFile->storeAs('public/cv_files', $fileName);
            $data['cv_file'] = $fileName;
        }
        
        // Handle JSON data
        $data['skills'] = $this->processJsonField($request->skills_json);
        $data['languages'] = $this->processJsonField($request->languages_json);
        $data['education'] = $this->processJsonField($request->education_json);
        $data['work_experience'] = $this->processJsonField($request->work_experience_json);
        $data['certifications'] = $this->processJsonField($request->certifications_json);
        
        ZhyarCV::create($data);
        
        return redirect()->route('admin.zhyar-cv.index')
            ->with('success', 'CV created successfully');
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
    public function update(Request $request, ZhyarCV $zhyarCv)
    {
        $validator = Validator::make($request->all(), [
            'professional_title' => 'required|string|max:255',
            'summary' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['cv_file']);
        
        // Handle CV file upload
        if ($request->hasFile('cv_file')) {
            // Delete old file if exists
            if ($zhyarCv->cv_file) {
                Storage::delete('public/cv_files/' . $zhyarCv->cv_file);
            }
            
            $cvFile = $request->file('cv_file');
            $fileName = 'zhyar_cv_' . time() . '.' . $cvFile->getClientOriginalExtension();
            $cvFile->storeAs('public/cv_files', $fileName);
            $data['cv_file'] = $fileName;
        }
        
        // Handle JSON data
        $data['skills'] = $this->processJsonField($request->skills_json);
        $data['languages'] = $this->processJsonField($request->languages_json);
        $data['education'] = $this->processJsonField($request->education_json);
        $data['work_experience'] = $this->processJsonField($request->work_experience_json);
        $data['certifications'] = $this->processJsonField($request->certifications_json);
        
        $zhyarCv->update($data);
        
        return redirect()->route('admin.zhyar-cv.index')
            ->with('success', 'CV updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZhyarCV $zhyarCv)
    {
        // Delete CV file if exists
        if ($zhyarCv->cv_file) {
            Storage::delete('public/cv_files/' . $zhyarCv->cv_file);
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
} 