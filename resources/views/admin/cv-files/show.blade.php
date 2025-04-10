<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('CV File Details') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-500/10 text-blue-500 rounded-full border border-blue-500/20">CV Management</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">CV File Details</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.cv-files.edit', $cvFile) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        Edit CV File
                    </a>
                    <a href="{{ route('admin.cv-files.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- File Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">File Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="block font-medium text-gray-700">Filename:</span>
                                <span class="text-gray-900">{{ $cvFile->original_filename }}</span>
                            </div>
                            
                            <div>
                                <span class="block font-medium text-gray-700">File Type:</span>
                                <span class="text-gray-900">{{ strtoupper($cvFile->file_type) }}</span>
                            </div>
                            
                            <div>
                                <span class="block font-medium text-gray-700">File Size:</span>
                                <span class="text-gray-900">{{ $cvFile->file_size ? round($cvFile->file_size / 1024, 2) . ' KB' : 'Unknown' }}</span>
                            </div>
                            
                            <div>
                                <span class="block font-medium text-gray-700">Uploaded:</span>
                                <span class="text-gray-900">{{ $cvFile->created_at->format('F d, Y \a\t h:i A') }}</span>
                            </div>
                            
                            <div>
                                <span class="block font-medium text-gray-700">Status:</span>
                                @if ($cvFile->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description & Actions -->
                    <div>
                        @if ($cvFile->description)
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Description</h3>
                            <div class="prose prose-sm max-w-none mb-6">
                                <p class="text-gray-700">{{ $cvFile->description }}</p>
                            </div>
                        @endif
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Actions</h3>
                        
                        <div class="flex flex-col space-y-3 mt-4">
                            <a href="{{ asset('storage/' . $cvFile->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                View CV File
                            </a>
                            
                            @if (!$cvFile->is_active)
                                <form action="{{ route('admin.cv-files.set-active', $cvFile) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Set as Active CV
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.cv-files.destroy', $cvFile) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Delete CV File
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 