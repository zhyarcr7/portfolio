<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Contact Information') }}
            </h2>
            <a href="{{ route('admin.contact-information.index') }}" class="px-4 py-2 bg-blue-800/70 text-white rounded-md hover:bg-blue-700 transition">
                {{ __('Back to Details') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.contact-information.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">Address Information</h3>
                                
                                <div>
                                    <x-input-label for="address" :value="__('Street Address')" />
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $contactInfo->address)" />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $contactInfo->city)" />
                                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="state" :value="__('State/Province')" />
                                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $contactInfo->state)" />
                                        <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="postal_code" :value="__('Postal Code')" />
                                        <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $contactInfo->postal_code)" />
                                        <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="country" :value="__('Country')" />
                                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $contactInfo->country)" />
                                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="map_url" :value="__('Google Maps Embed URL')" />
                                    <x-text-input id="map_url" name="map_url" type="text" class="mt-1 block w-full" :value="old('map_url', $contactInfo->map_url)" />
                                    <x-input-error :messages="$errors->get('map_url')" class="mt-2" />
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Example: https://www.google.com/maps/embed?pb=...</p>
                                </div>
                                
                                <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 mt-8">Contact Details</h3>
                                
                                <div>
                                    <x-input-label for="email" :value="__('Email Address')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $contactInfo->email)" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Phone Number')" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $contactInfo->phone)" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="website" :value="__('Website')" />
                                    <x-text-input id="website" name="website" type="text" class="mt-1 block w-full" :value="old('website', $contactInfo->website)" />
                                    <x-input-error :messages="$errors->get('website')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="opening_hours" :value="__('Opening Hours')" />
                                    <textarea id="opening_hours" name="opening_hours" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-blue-900/90 dark:text-gray-300 focus:border-[#FF750F] focus:ring-[#FF750F] dark:focus:border-[#FF750F] dark:focus:ring-[#FF750F] shadow-sm">{{ old('opening_hours', $contactInfo->opening_hours) }}</textarea>
                                    <x-input-error :messages="$errors->get('opening_hours')" class="mt-2" />
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Example: Monday - Friday: 9am - 5pm</p>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">Social Media</h3>
                                
                                <div>
                                    <x-input-label for="facebook" :value="__('Facebook URL')" />
                                    <x-text-input id="facebook" name="facebook" type="text" class="mt-1 block w-full" :value="old('facebook', $contactInfo->facebook)" />
                                    <x-input-error :messages="$errors->get('facebook')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="twitter" :value="__('Twitter URL')" />
                                    <x-text-input id="twitter" name="twitter" type="text" class="mt-1 block w-full" :value="old('twitter', $contactInfo->twitter)" />
                                    <x-input-error :messages="$errors->get('twitter')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="instagram" :value="__('Instagram URL')" />
                                    <x-text-input id="instagram" name="instagram" type="text" class="mt-1 block w-full" :value="old('instagram', $contactInfo->instagram)" />
                                    <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="linkedin" :value="__('LinkedIn URL')" />
                                    <x-text-input id="linkedin" name="linkedin" type="text" class="mt-1 block w-full" :value="old('linkedin', $contactInfo->linkedin)" />
                                    <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="whatsapp" :value="__('WhatsApp Number')" />
                                    <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full" :value="old('whatsapp', $contactInfo->whatsapp)" />
                                    <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Example: +1234567890</p>
                                </div>
                                
                                <div class="flex items-center mt-8 pt-4">
                                    <input id="is_active" name="is_active" type="checkbox" class="rounded dark:bg-blue-900/90 border-gray-300 dark:border-gray-700 text-[#FF750F] shadow-sm focus:ring-[#FF750F] dark:focus:ring-[#FF750F] dark:focus:ring-offset-gray-800" {{ $contactInfo->is_active ? 'checked' : '' }}>
                                    <label for="is_active" class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Active') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <x-primary-button class="ml-4">
                                {{ __('Save Contact Information') }}
                            </x-primary-button>
                        </div>
                    </form>
                    
                    <hr class="my-8 border-gray-300 dark:border-gray-700">
                    
                    <h3 class="text-lg font-semibold mb-4">Quick Test Form</h3>
                    <form action="{{ url('/test-contact-update') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="test_email" :value="__('Test Email')" />
                            <x-text-input id="test_email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $contactInfo->email)" />
                        </div>
                        <div>
                            <x-input-label for="test_phone" :value="__('Test Phone')" />
                            <x-text-input id="test_phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $contactInfo->phone)" />
                        </div>
                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Test Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 