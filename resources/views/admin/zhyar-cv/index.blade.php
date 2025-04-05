<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Zhyar CV Management') }}
            </h2>
            <a href="{{ route('admin.zhyar-cv.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New CV
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Professional Title</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-left">Last Updated</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cvs as $cv)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="py-4 px-6">{{ $cv->id }}</td>
                                        <td class="py-4 px-6">{{ $cv->professional_title }}</td>
                                        <td class="py-4 px-6">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cv->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $cv->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">{{ $cv->updated_at->format('M d, Y H:i') }}</td>
                                        <td class="py-4 px-6 flex space-x-2">
                                            <a href="{{ route('admin.zhyar-cv.show', $cv) }}" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('admin.zhyar-cv.edit', $cv) }}" class="text-yellow-500 hover:text-yellow-700">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.zhyar-cv.toggle-active', $cv) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-purple-500 hover:text-purple-700">
                                                    <i class="fas fa-toggle-on"></i> {{ $cv->is_active ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.zhyar-cv.destroy', $cv) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this CV?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center">No CV records found. <a href="{{ route('admin.zhyar-cv.create') }}" class="text-blue-500 hover:underline">Create one</a>.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 