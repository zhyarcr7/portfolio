<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">CV Database Diagnostic</h1>
                
                <!-- Summary Information -->
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Summary</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="p-3 bg-white dark:bg-gray-600 rounded shadow">
                            <span class="text-sm text-gray-500 dark:text-gray-300">Total CV Records</span>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $results['total_records'] }}</div>
                        </div>
                        
                        <div class="p-3 bg-white dark:bg-gray-600 rounded shadow">
                            <span class="text-sm text-gray-500 dark:text-gray-300">Active CV</span>
                            <div class="text-2xl font-bold {{ $results['has_active_cv'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $results['has_active_cv'] ? 'Yes (ID: '.$results['active_cv_id'].')' : 'No' }}
                            </div>
                        </div>
                        
                        <div class="p-3 bg-white dark:bg-gray-600 rounded shadow">
                            <span class="text-sm text-gray-500 dark:text-gray-300">Storage Link Status</span>
                            <div class="text-2xl font-bold {{ $results['storage_link_exists'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $results['storage_link_exists'] ? 'Working' : 'Missing' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Direct CV File Status -->
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Direct CV File Status</h2>
                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <div class="w-4 h-4 rounded-full mr-2 {{ $results['zhyar_cv_exists'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                            <span class="font-medium">zhyar_cv.pdf: {{ $results['zhyar_cv_exists'] ? 'Exists' : 'Not Found' }}</span>
                        </div>
                        @if($results['zhyar_cv_exists'])
                            <div class="mt-2 flex items-center space-x-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">URL:</span>
                                <a href="{{ $results['zhyar_cv_url'] }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline truncate">
                                    {{ $results['zhyar_cv_url'] }}
                                </a>
                                <a href="{{ $results['zhyar_cv_url'] }}" target="_blank" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">View</a>
                            </div>
                        @else
                            <div class="mt-2 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                                <p class="font-medium">The direct CV file (zhyar_cv.pdf) is missing in the public storage directory.</p>
                                <p class="mt-1">This file is needed for the direct download button on your website.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Detailed CV Records -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">CV Records</h2>
                    
                    @if(count($results['records']) > 0)
                        @foreach($results['records'] as $record)
                            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">ID: {{ $record['id'] }}</h3>
                                        <div class="flex items-center mt-1">
                                            <span class="px-2 py-1 {{ $record['is_active'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded-full text-xs font-medium mr-2">
                                                {{ $record['is_active'] ? 'Active' : 'Inactive' }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                Updated: {{ $record['updated_at'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.zhyar-cv.edit', $record['id']) }}" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Professional Title</span>
                                        <span class="block text-gray-900 dark:text-white">{{ $record['professional_title'] }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Summary</span>
                                        <span class="block text-gray-900 dark:text-white">{{ $record['summary'] }}</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2 {{ $record['has_skills'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="text-sm">Skills</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2 {{ $record['has_education'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="text-sm">Education</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2 {{ $record['has_work_experience'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="text-sm">Work Experience</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2 {{ $record['has_certifications'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="text-sm">Certifications</span>
                                    </div>
                                </div>
                                
                                <!-- CV File Information -->
                                @if(isset($record['cv_file']) && $record['cv_file'])
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <h4 class="font-medium mb-2 text-gray-900 dark:text-white">CV File</h4>
                                        <div class="bg-white dark:bg-gray-600 p-3 rounded shadow">
                                            <div class="flex items-center mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span class="font-medium">{{ $record['cv_file'] }}</span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-sm mb-1">Standard Storage Location:</p>
                                                    <div class="flex items-center">
                                                        <div class="w-3 h-3 rounded-full mr-2 {{ isset($record['file_exists_in_cv_files']) && $record['file_exists_in_cv_files'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                                        <span class="text-sm">{{ isset($record['file_exists_in_cv_files']) && $record['file_exists_in_cv_files'] ? 'File exists' : 'File not found' }}</span>
                                                    </div>
                                                    @if(isset($record['file_url']))
                                                        <a href="{{ $record['file_url'] }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 hover:underline mt-1 inline-block">
                                                            View File
                                                        </a>
                                                    @endif
                                                </div>
                                                
                                                <div>
                                                    <p class="text-sm mb-1">Direct Storage Location:</p>
                                                    <div class="flex items-center">
                                                        <div class="w-3 h-3 rounded-full mr-2 {{ isset($record['file_exists_in_public']) && $record['file_exists_in_public'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                                        <span class="text-sm">{{ isset($record['file_exists_in_public']) && $record['file_exists_in_public'] ? 'File exists' : 'File not found' }}</span>
                                                    </div>
                                                    @if(isset($record['direct_file_url']))
                                                        <a href="{{ $record['direct_file_url'] }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 hover:underline mt-1 inline-block">
                                                            View File
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 text-yellow-700">
                                            <p class="font-medium">No CV file has been uploaded for this record.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                            <p class="text-gray-500 dark:text-gray-400">No CV records found in the database.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Quick Fix Options -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Quick Fix Options</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h3 class="font-medium mb-2 text-gray-900 dark:text-white">Upload New CV File</h3>
                            <form id="quickUploadForm" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <input type="file" name="cv_file" class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept=".pdf,.doc,.docx">
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Upload & Fix
                                </button>
                            </form>
                            <div id="quickUploadStatus" class="hidden mt-4 p-4 rounded"></div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h3 class="font-medium mb-2 text-gray-900 dark:text-white">Fix Database Record</h3>
                            <form id="fixDatabaseForm" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Active CV</label>
                                    <select id="active_cv_id" name="active_cv_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        @foreach($results['records'] as $record)
                                            <option value="{{ $record['id'] }}" {{ $record['is_active'] ? 'selected' : '' }}>
                                                ID {{ $record['id'] }}: {{ $record['professional_title'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CV Filename</label>
                                    <input type="text" id="cv_filename" name="cv_filename" value="zhyar_cv.pdf" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Update Database
                                </button>
                            </form>
                            <div id="fixDatabaseStatus" class="hidden mt-4 p-4 rounded"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between mt-8">
                    <a href="{{ route('admin.zhyar-cv.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Back to CV List
                    </a>
                    <a href="{{ route('admin.cv.database-check') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Refresh Diagnostics
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quick Upload Form
            const quickUploadForm = document.getElementById('quickUploadForm');
            const quickUploadStatus = document.getElementById('quickUploadStatus');
            
            if (quickUploadForm) {
                quickUploadForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(quickUploadForm);
                    
                    // Clear previous status
                    quickUploadStatus.className = 'hidden mt-4 p-4 rounded';
                    quickUploadStatus.innerHTML = '';
                    
                    // Show loading state
                    quickUploadStatus.className = 'block mt-4 p-4 rounded bg-blue-100 text-blue-700';
                    quickUploadStatus.innerHTML = '<p>Uploading and fixing CV file...</p>';
                    
                    fetch('{{ route("admin.cv.upload-direct") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            quickUploadStatus.className = 'block mt-4 p-4 rounded bg-green-100 text-green-700';
                            quickUploadStatus.innerHTML = `
                                <p class="font-medium">CV uploaded successfully!</p>
                                <p class="mt-1">The CV file is now available at: <a href="${data.file_url}" target="_blank" class="underline">${data.file_url}</a></p>
                                <p class="mt-1">Refresh this page to see the changes.</p>
                            `;
                        } else {
                            quickUploadStatus.className = 'block mt-4 p-4 rounded bg-red-100 text-red-700';
                            quickUploadStatus.innerHTML = `<p class="font-medium">Error: ${data.message || 'Failed to upload CV'}</p>`;
                        }
                    })
                    .catch(error => {
                        quickUploadStatus.className = 'block mt-4 p-4 rounded bg-red-100 text-red-700';
                        quickUploadStatus.innerHTML = `<p class="font-medium">Error: ${error.message || 'Failed to upload CV'}</p>`;
                    });
                });
            }
            
            // Fix Database Form
            const fixDatabaseForm = document.getElementById('fixDatabaseForm');
            const fixDatabaseStatus = document.getElementById('fixDatabaseStatus');
            
            if (fixDatabaseForm) {
                fixDatabaseForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(fixDatabaseForm);
                    
                    // Clear previous status
                    fixDatabaseStatus.className = 'hidden mt-4 p-4 rounded';
                    fixDatabaseStatus.innerHTML = '';
                    
                    // Show loading state
                    fixDatabaseStatus.className = 'block mt-4 p-4 rounded bg-blue-100 text-blue-700';
                    fixDatabaseStatus.innerHTML = '<p>Updating database record...</p>';
                    
                    fetch('{{ route("admin.cv.fix-database") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fixDatabaseStatus.className = 'block mt-4 p-4 rounded bg-green-100 text-green-700';
                            fixDatabaseStatus.innerHTML = `
                                <p class="font-medium">Database updated successfully!</p>
                                <p class="mt-1">${data.message}</p>
                                <p class="mt-1">Refresh this page to see the changes.</p>
                            `;
                        } else {
                            fixDatabaseStatus.className = 'block mt-4 p-4 rounded bg-red-100 text-red-700';
                            fixDatabaseStatus.innerHTML = `<p class="font-medium">Error: ${data.message || 'Failed to update database'}</p>`;
                        }
                    })
                    .catch(error => {
                        fixDatabaseStatus.className = 'block mt-4 p-4 rounded bg-red-100 text-red-700';
                        fixDatabaseStatus.innerHTML = `<p class="font-medium">Error: ${error.message || 'Failed to update database'}</p>`;
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 