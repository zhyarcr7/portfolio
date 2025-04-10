@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit CV File</h1>
        <a href="{{ route('cv-files.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Back to List
        </a>
    </div>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
        <form action="{{ route('cv-files.update', $cvFile) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <h3 class="block text-sm font-medium text-gray-700 mb-2">Current File</h3>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $cvFile->original_filename }}</p>
                        <p class="text-xs text-gray-500">{{ strtoupper($cvFile->file_type) }} - {{ $cvFile->file_size ? round($cvFile->file_size / 1024, 2) . ' KB' : 'Unknown size' }}</p>
                    </div>
                    <a href="{{ asset('storage/' . $cvFile->file_path) }}" target="_blank" class="ml-auto text-blue-600 hover:text-blue-800">
                        View
                    </a>
                </div>
            </div>

            <div class="mb-6">
                <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">Replace File (optional)</label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex justify-center items-center hover:bg-gray-50 cursor-pointer">
                    <input type="file" name="file_path" id="file_path" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.doc,.docx">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="mt-1 text-sm text-gray-600" id="file-name">Click to select a file or drag and drop</p>
                    </div>
                </div>
                @error('file_path')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
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

<script>
    document.getElementById('file_path').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Click to select a file or drag and drop';
        document.getElementById('file-name').textContent = fileName;
    });
</script>
@endsection 