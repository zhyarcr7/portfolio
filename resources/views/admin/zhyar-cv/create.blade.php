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
                                    <label for="professional_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional Title</label>
                                    <input type="text" name="professional_title" id="professional_title" value="{{ old('professional_title') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    @error('professional_title')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Summary -->
                                <div>
                                    <label for="summary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional Summary</label>
                                    <textarea name="summary" id="summary" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('summary') }}</textarea>
                                    @error('summary')
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
                                    <label for="cv_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CV File (PDF)</label>
                                    <input type="file" name="cv_file" id="cv_file" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-400">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Upload a PDF file of the CV for download.</p>
                                    @error('cv_file')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
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
</x-app-layout> 