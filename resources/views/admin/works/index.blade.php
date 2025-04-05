<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portfolio Works') }}
            </h2>
            <a href="{{ route('admin.works.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add New Work
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($works as $work)
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                @if(count($work->images ?? []) > 0)
                                    <img src="{{ Storage::url($work->images[0]) }}" alt="{{ $work->title }}" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $work->title }}</h3>
                                            <p class="text-sm text-gray-500">{{ $work->category }}</p>
                                        </div>
                                        @if($work->featured)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $work->description }}</p>
                                    <div class="mt-4 flex justify-end space-x-3">
                                        <a href="{{ route('admin.works.edit', $work) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.works.destroy', $work) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this work?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 text-gray-500">
                                No portfolio works found.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $works->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 