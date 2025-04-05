<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Testimonials') }}
            </h2>
            <a href="{{ route('admin.testimonials.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add New Testimonial
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
                        @forelse ($testimonials as $testimonial)
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="p-4">
                                    <div class="flex items-center mb-4">
                                        <img src="{{ Storage::url($testimonial->image) }}" alt="{{ $testimonial->name }}" class="h-12 w-12 rounded-full object-cover">
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $testimonial->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $testimonial->position }} at {{ $testimonial->company }}</p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="h-5 w-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4">{{ $testimonial->feedback }}</p>
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this testimonial?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 text-gray-500">
                                No testimonials found.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $testimonials->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 