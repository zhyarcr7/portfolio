@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">CV File Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('cv-files.edit', $cvFile) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Edit
            </a>
            <a href="{{ route('cv-files.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $cvFile->original_filename }}</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">File Type</h3>
                            <p>{{ strtoupper($cvFile->file_type) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">File Size</h3>
                            <p>{{ $cvFile->file_size ? round($cvFile->file_size / 1024, 2) . ' KB' : 'Unknown' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Uploaded On</h3>
                            <p>{{ $cvFile->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Status</h3>
                            <p>
                                @if ($cvFile->is_active)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if ($cvFile->description)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                {{ $cvFile->description }}
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="ml-6 flex flex-col items-end">
                    <div class="bg-gray-100 p-4 rounded-lg mb-4 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="mt-2 text-sm text-gray-600">
                            <a href="{{ asset('storage/' . $cvFile->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">
                                View CV File
                            </a>
                        </div>
                    </div>
                    
                    @if (!$cvFile->is_active)
                        <form action="{{ route('cv-files.set-active', $cvFile) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                Set as Active
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 