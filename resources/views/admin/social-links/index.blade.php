<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Social Media Links') }}
            </h2>
            <a href="{{ route('admin.social-links.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                {{ __('Add New Link') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(count($socialLinks) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Order</th>
                                        <th class="py-3 px-4 text-left">Platform</th>
                                        <th class="py-3 px-4 text-left">Icon</th>
                                        <th class="py-3 px-4 text-left">URL</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($socialLinks as $link)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="py-3 px-4">{{ $link->order }}</td>
                                            <td class="py-3 px-4">{{ $link->platform }}</td>
                                            <td class="py-3 px-4">
                                                <i class="{{ $link->icon_class }} text-indigo-500 text-xl"></i>
                                            </td>
                                            <td class="py-3 px-4 break-all">
                                                <a href="{{ $link->url }}" target="_blank" class="text-blue-500 hover:underline">
                                                    {{ Str::limit($link->url, 30) }}
                                                </a>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-1 rounded-full text-xs {{ $link->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                    {{ $link->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.social-links.edit', $link->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.social-links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this link?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-5xl mb-4">
                                <i class="fas fa-link"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">No Social Links Found</h3>
                            <p class="text-gray-500 mb-6">Start adding your social media links to display on your website.</p>
                            <a href="{{ route('admin.social-links.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                                Add Your First Link
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 