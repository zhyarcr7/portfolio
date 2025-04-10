<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Edit CV File') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-500/10 text-blue-500 rounded-full border border-blue-500/20">CV Management</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit CV File</h1>
                <a href="{{ route('admin.cv-files.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Back to List
                </a>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                <!-- Current File Information -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Current File Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="block font-medium text-gray-700">Filename:</span>
                            <span>{{ $cvFile->original_filename }}</span>
                        </div>
                        <div>
                            <span class="block font-medium text-gray-700">Type:</span>
                            <span>{{ strtoupper($cvFile->file_type) }}</span>
                        </div>
                        <div>
                            <span class="block font-medium text-gray-700">Size:</span>
                            <span>{{ $cvFile->file_size ? round($cvFile->file_size / 1024, 2) . ' KB' : 'Unknown' }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $cvFile->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">View Current File</a>
                    </div>
                </div>

                <form action="{{ route('admin.cv-files.update', $cvFile) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">Replace CV File (Optional)</label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex justify-center items-center hover:bg-gray-50 cursor-pointer">
                            <input type="file" name="file_path" id="file_path" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.doc,.docx">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mt-1 text-sm text-gray-600" id="file-name">Click to select a new file or drag and drop</p>
                                <p class="mt-1 text-xs text-gray-500">Leave empty to keep the current file</p>
                            </div>
                        </div>
                        @error('file_path')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (optional)</label>
                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2">{{ old('description', $cvFile->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ $cvFile->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Set as active CV (used for download button)
                            </label>
                        </div>
                        @error('is_active')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Update CV
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('file_path').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Click to select a new file or drag and drop';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
    @endpush
</x-app-layout> 