<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add Social Media Link') }}
            </h2>
            <a href="{{ route('admin.social-links.index') }}" class="px-4 py-2 bg-blue-800/70 text-white rounded-md hover:bg-blue-700 transition">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.social-links.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="platform" :value="__('Platform Name')" />
                            <x-text-input id="platform" name="platform" type="text" class="mt-1 block w-full" :value="old('platform')" required autofocus />
                            <x-input-error :messages="$errors->get('platform')" class="mt-2" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">E.g., Facebook, Twitter, LinkedIn, etc.</p>
                        </div>

                        <div>
                            <x-input-label for="url" :value="__('URL')" />
                            <x-text-input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('url')" required />
                            <x-input-error :messages="$errors->get('url')" class="mt-2" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Full URL including https://</p>
                        </div>

                        <div>
                            <x-input-label for="icon_class" :value="__('Icon Class')" />
                            <x-text-input id="icon_class" name="icon_class" type="text" class="mt-1 block w-full" :value="old('icon_class')" required />
                            <x-input-error :messages="$errors->get('icon_class')" class="mt-2" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Font Awesome icon class, e.g., "fab fa-facebook", "fab fa-twitter". 
                                <a href="https://fontawesome.com/icons?d=gallery&s=brands" class="text-blue-500 hover:underline" target="_blank">
                                    Browse Font Awesome Icons
                                </a>
                            </p>
                        </div>

                        <div>
                            <x-input-label for="order" :value="__('Display Order')" />
                            <x-text-input id="order" name="order" type="number" class="mt-1 block w-full" :value="old('order', 0)" />
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lower numbers will appear first</p>
                        </div>

                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" class="rounded dark:bg-blue-900/90 border-gray-300 dark:border-gray-700 text-[#FF750F] shadow-sm focus:ring-[#FF750F] dark:focus:ring-[#FF750F] dark:focus:ring-offset-gray-800" checked>
                            <label for="is_active" class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Active') }}</label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Add Social Link') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 