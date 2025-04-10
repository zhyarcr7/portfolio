<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New CV') }}
            </h2>
            <a href="{{ route('admin.zhyar-cv.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.zhyar-cv.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Professional Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    @error('title')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Summary -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional Summary</label>
                                    <textarea name="content" id="content" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Skills (JSON) -->
                                <div>
                                    <label for="skills_json" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skills (JSON format)</label>
                                    <textarea name="skills_json" id="skills_json" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-mono text-sm">{{ old('skills_json') ?: '{"Programming Languages": ["PHP", "JavaScript", "HTML/CSS", "SQL"], "Frameworks": ["Laravel", "Vue.js", "Tailwind CSS"]}' }}</textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enter skills in valid JSON format. Use an object with categories as keys and arrays of skills as values.</p>
                                </div>
                                
                                <!-- Languages (JSON) -->
                                <div>
                                    <label for="languages_json" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Languages (JSON format)</label>
                                    <textarea name="languages_json" id="languages_json" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-mono text-sm">{{ old('languages_json') ?: '[{"name": "English", "proficiency": "Fluent"}, {"name": "Kurdish", "proficiency": "Native"}]' }}</textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enter languages in valid JSON format as an array of objects with name and proficiency properties.</p>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Education (JSON) -->
                                <div>
                                    <label for="education_json" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Education (JSON format)</label>
                                    <textarea name="education_json" id="education_json" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-mono text-sm">{{ old('education_json') ?: '[{"degree": "Bachelor of Science in Computer Science", "institution": "University Name", "location": "City, Country", "year_start": "2014", "year_end": "2018", "description": "Graduated with honors."}]' }}</textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enter education in valid JSON format.</p>
                                </div>
                                
                                <!-- Work Experience (JSON) -->
                                <div>
                                    <label for="work_experience_json" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Work Experience (JSON format)</label>
                                    <textarea name="work_experience_json" id="work_experience_json" rows="8" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-mono text-sm">{{ old('work_experience_json') ?: '[{"position": "Senior Web Developer", "company": "Tech Company", "location": "City, Country", "year_start": "2020", "year_end": "Present", "responsibilities": ["Led development of web applications", "Implemented CI/CD pipelines"]}]' }}</textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enter work experience in valid JSON format.</p>
                                </div>
                                
                                <!-- Certifications (JSON) -->
                                <div>
                                    <label for="certifications_json" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Certifications (JSON format)</label>
                                    <textarea name="certifications_json" id="certifications_json" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-mono text-sm">{{ old('certifications_json') ?: '[{"name": "Laravel Certified Developer", "issuer": "Laravel", "year": "2021", "description": "Official certification for Laravel framework expertise"}]' }}</textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enter certifications in valid JSON format.</p>
                                </div>
                                
                                <!-- CV File Upload -->
                                <div>
                                    <label class="relative flex hover:bg-gray-50 cursor-pointer rounded-md p-4 border-2 border-dashed border-gray-300">
                                        <input type="file" name="cv_file" id="file_path" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" accept=".pdf,.doc,.docx">
                                        <div class="w-full text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <span class="mt-2 block text-sm font-medium text-gray-700">
                                                Drop your CV file here or click to upload
                                            </span>
                                            <span class="mt-1 block text-sm text-gray-500" id="file_path">
                                                PDF (max 10MB)
                                            </span>
                                        </div>
                                    </label>
                                    
                                    <!-- Hidden input for direct file path -->
                                    <input type="hidden" name="direct_file_path" id="direct_file_path">
                                </div>
                                
                                <!-- Active Status -->
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save CV
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Direct CV Upload Form -->
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Direct CV Upload</h2>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        This will upload a CV file directly as <strong>zhyar_cv.pdf</strong> to the public directory. 
                        This is useful when you need to keep the same file name for direct downloads.
                    </p>
                </div>
            </div>
        </div>

        <form id="directCvUploadForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="direct_cv_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CV File (PDF)</label>
                <input type="file" name="cv_file" id="direct_cv_file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept=".pdf,.doc,.docx">
                <p class="mt-1 text-sm text-gray-500">Upload a PDF file (max 10MB). This will be saved as zhyar_cv.pdf.</p>
            </div>
            
            <div class="flex items-center justify-end">
                <button type="submit" id="directCvUploadButton" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Upload Direct CV
                </button>
            </div>
            
            <div id="directUploadStatus" class="hidden mt-4 p-4 rounded"></div>
        </form>
    </div>
</x-app-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const directForm = document.getElementById('directCvUploadForm');
        const directButton = document.getElementById('directCvUploadButton');
        const directStatus = document.getElementById('directUploadStatus');
        
        directForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(directForm);
            directButton.disabled = true;
            directButton.innerText = 'Uploading...';
            
            // Clear previous status
            directStatus.className = 'hidden mt-4 p-4 rounded';
            directStatus.innerHTML = '';
            
            fetch('{{ route("admin.cv.upload-direct") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                directButton.disabled = false;
                directButton.innerText = 'Upload Direct CV';
                
                if (data.success) {
                    directStatus.className = 'block mt-4 p-4 rounded bg-green-100 text-green-700';
                    directStatus.innerHTML = `
                        <p class="font-medium">CV uploaded successfully!</p>
                        <p class="mt-1">The CV file is now available at: <a href="${data.file_url}" target="_blank" class="underline">${data.file_url}</a></p>
                        <p class="mt-2">You can use this file path in the form above: <code class="bg-gray-100 text-gray-800 px-2 py-1 rounded">zhyar_cv.pdf</code></p>
                    `;
                    
                    // Update the hidden input field with the direct file path
                    document.getElementById('direct_file_path').value = data.file_path;
                    
                    // Update the file name display in the main form
                    document.getElementById('cv_file_name').textContent = 'Using direct upload: ' + data.file_path;
                    
                    // Show a success notification
                    const mainForm = document.querySelector('form[action*="zhyar-cv"]');
                    const notification = document.createElement('div');
                    notification.className = 'mb-4 p-4 rounded bg-green-100 text-green-700';
                    notification.innerHTML = `
                        <p class="font-medium">Direct CV file uploaded successfully!</p>
                        <p class="mt-1">The file path has been added to the form. Continue filling in the form and submit to create the CV record.</p>
                    `;
                    mainForm.insertBefore(notification, mainForm.firstChild);
                } else {
                    directStatus.className = 'block mt-4 p-4 rounded bg-red-100 text-red-700';
                    directStatus.innerHTML = `<p class="font-medium">Error: ${data.message || 'Failed to upload CV'}</p>`;
                }
            })
            .catch(error => {
                directButton.disabled = false;
                directButton.innerText = 'Upload Direct CV';
                directStatus.className = 'block mt-4 p-4 rounded bg-red-100 text-red-700';
                directStatus.innerHTML = `<p class="font-medium">Error: ${error.message || 'Failed to upload CV'}</p>`;
            });
        });
    });
</script>
@endpush 