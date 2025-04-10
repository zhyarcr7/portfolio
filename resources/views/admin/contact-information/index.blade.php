<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Contact Information') }}
            </h2>
            <a href="{{ route('admin.contact-information.edit') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                {{ __('Edit Contact Information') }}
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
                    
                    @if (session('error'))
                        <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Status</h3>
                        <div class="flex items-center">
                            <span class="px-3 py-1 rounded-full text-sm {{ $contactInfo->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $contactInfo->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    @if($contactInfo->exists)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Contact Details</h3>
                                
                                @if($contactInfo->address || $contactInfo->city || $contactInfo->state || $contactInfo->postal_code || $contactInfo->country)
                                    <div class="mb-4">
                                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Address</h4>
                                        <p>{{ $contactInfo->full_address }}</p>
                                    </div>
                                @endif
                                
                                @if($contactInfo->email)
                                    <div class="mb-4">
                                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Email</h4>
                                        <p><a href="mailto:{{ $contactInfo->email }}" class="text-blue-500 hover:underline">{{ $contactInfo->email }}</a></p>
                                    </div>
                                @endif
                                
                                @if($contactInfo->phone)
                                    <div class="mb-4">
                                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Phone</h4>
                                        <p><a href="tel:{{ $contactInfo->phone }}" class="text-blue-500 hover:underline">{{ $contactInfo->phone }}</a></p>
                                    </div>
                                @endif
                                
                                @if($contactInfo->website)
                                    <div class="mb-4">
                                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Website</h4>
                                        <p><a href="{{ $contactInfo->website }}" target="_blank" class="text-blue-500 hover:underline">{{ $contactInfo->website }}</a></p>
                                    </div>
                                @endif
                                
                                @if($contactInfo->opening_hours)
                                    <div class="mb-4">
                                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Opening Hours</h4>
                                        <p class="whitespace-pre-line">{{ $contactInfo->opening_hours }}</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Social Media</h3>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    @if($contactInfo->facebook)
                                        <div class="mb-2">
                                            <h4 class="font-medium text-gray-700 dark:text-gray-300">Facebook</h4>
                                            <p><a href="{{ $contactInfo->facebook }}" target="_blank" class="text-blue-500 hover:underline">
                                                <i class="fab fa-facebook-f mr-1"></i> View Profile
                                            </a></p>
                                        </div>
                                    @endif
                                    
                                    @if($contactInfo->twitter)
                                        <div class="mb-2">
                                            <h4 class="font-medium text-gray-700 dark:text-gray-300">Twitter</h4>
                                            <p><a href="{{ $contactInfo->twitter }}" target="_blank" class="text-blue-500 hover:underline">
                                                <i class="fab fa-twitter mr-1"></i> View Profile
                                            </a></p>
                                        </div>
                                    @endif
                                    
                                    @if($contactInfo->instagram)
                                        <div class="mb-2">
                                            <h4 class="font-medium text-gray-700 dark:text-gray-300">Instagram</h4>
                                            <p><a href="{{ $contactInfo->instagram }}" target="_blank" class="text-blue-500 hover:underline">
                                                <i class="fab fa-instagram mr-1"></i> View Profile
                                            </a></p>
                                        </div>
                                    @endif
                                    
                                    @if($contactInfo->linkedin)
                                        <div class="mb-2">
                                            <h4 class="font-medium text-gray-700 dark:text-gray-300">LinkedIn</h4>
                                            <p><a href="{{ $contactInfo->linkedin }}" target="_blank" class="text-blue-500 hover:underline">
                                                <i class="fab fa-linkedin-in mr-1"></i> View Profile
                                            </a></p>
                                        </div>
                                    @endif
                                    
                                    @if($contactInfo->whatsapp)
                                        <div class="mb-2">
                                            <h4 class="font-medium text-gray-700 dark:text-gray-300">WhatsApp</h4>
                                            <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo->whatsapp) }}" target="_blank" class="text-blue-500 hover:underline">
                                                <i class="fab fa-whatsapp mr-1"></i> {{ $contactInfo->whatsapp }}
                                            </a></p>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($contactInfo->map_url)
                                    <div class="mt-6">
                                        <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Map Location</h4>
                                        <div class="aspect-video w-full overflow-hidden rounded">
                                            <iframe class="w-full h-full" src="{{ $contactInfo->map_url }}" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-5xl mb-4">
                                <i class="fas fa-address-card"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">No Contact Information Found</h3>
                            <p class="text-gray-500 mb-6">Add your contact information to display on your website.</p>
                            <a href="{{ route('admin.contact-information.edit') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                                Add Contact Information
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 