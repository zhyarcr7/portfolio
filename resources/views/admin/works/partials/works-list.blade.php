@if(isset($works) && $works->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($works as $item)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($item->thumbnail_url)
                    <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->category }}</p>
                        </div>
                        @if($item->featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                Featured
                            </span>
                        @endif
                    </div>
                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $item->description }}</p>
                    <div class="mt-4 flex justify-end space-x-3">
                        <a href="{{ route('admin.works.edit', $item->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('admin.works.destroy', $item->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this work?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $works->links() }}
    </div>
@else
    <div class="text-center py-12 text-gray-500">
        No portfolio works found.
    </div>
@endif 