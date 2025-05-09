<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <!-- i need show by navigation database all by dinamic -->
                @foreach ($navigationItems as $item)
                    <x-nav-link :href="route($item->url)" :active="request()->routeIs($item->url)">
                        {{ $item->name }}
                    </x-nav-link>
                @endforeach
                <!-- CV Files Navigation -->
                <x-nav-link :href="route('admin.cv-files.index')" :active="request()->routeIs('admin.cv-files.*')">
                    {{ __('CV Files') }}
                </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Messages Icon -->
                <a href="{{ route('chat.index') }}" class="relative mr-4 p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none transition">
                    <span class="sr-only">View messages</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    
                    <!-- Notification Badge -->
                    <span id="unread-message-count" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] rounded-full hidden">0</span>
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ Auth::user()->is_admin ? route('admin.logout') : route('user.logout') }}">
                            @csrf

                            <x-dropdown-link :href="Auth::user()->is_admin ? route('admin.logout') : route('user.logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.blogs.index')" :active="request()->routeIs('admin.blogs.*')">
                {{ __('Blogs') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.works.index')" :active="request()->routeIs('admin.works.*')">
                {{ __('Works') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.testimonials.index')" :active="request()->routeIs('admin.testimonials.*')">
                {{ __('Testimonials') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.hero-slides.index')" :active="request()->routeIs('admin.hero-slides.*')">
                {{ __('Hero Slides') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.coming-soon.index')" :active="request()->routeIs('admin.coming-soon.*')">
                {{ __('Coming Soon') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.social-links.index')" :active="request()->routeIs('admin.social-links.*')">
                {{ __('Social Links') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.contact-information.index')" :active="request()->routeIs('admin.contact-information.*')">
                {{ __('Contact Info') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.zhyar-cv.index')" :active="request()->routeIs('admin.zhyar-cv.*')">
                {{ __('Zhyar CV') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.cv-files.index')" :active="request()->routeIs('admin.cv-files.*')">
                {{ __('CV Files') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Messages Link for Mobile -->
                <x-responsive-nav-link :href="route('chat.index')" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    {{ __('Messages') }}
                    <span id="mobile-unread-message-count" class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-gradient-to-r from-[#4b0600] to-[#FF750F] rounded-full hidden">0</span>
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ Auth::user()->is_admin ? route('admin.logout') : route('user.logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="Auth::user()->is_admin ? route('admin.logout') : route('user.logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
