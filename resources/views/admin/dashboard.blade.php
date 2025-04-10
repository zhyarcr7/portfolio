<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
            <span class="px-3 py-1 text-xs bg-red-500/10 text-red-500 rounded-full border border-red-500/20">Admin Control Panel</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl mb-6 border border-blue-700/50">
                <div class="p-6 flex items-center justify-between relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-white mb-2">Welcome, Administrator</h3>
                        <p class="text-slate-300">Manage all aspects of your portfolio website from this central dashboard</p>
                        <div class="flex items-center gap-4 mt-4">
                            <span class="px-3 py-1 bg-blue-800/50 text-blue-300 text-sm rounded-full border border-blue-700/50">Admin Panel</span>
                            <span class="flex items-center gap-1 text-slate-300 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Full administrative access
                            </span>
                        </div>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-blue-800/20 to-transparent"></div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                <!-- Blogs -->
                <div class="group bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-300">Total Blogs</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Blog::count() }}</p>
                                </div>
                            </div>
                            <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-blue-800/50 rounded-full overflow-hidden">
                            <div class="h-1 bg-blue-500/50 w-3/4 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Works -->
                <div class="group bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-300">Portfolio Works</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Work::count() }}</p>
                                </div>
                            </div>
                            <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-blue-800/50 rounded-full overflow-hidden">
                            <div class="h-1 bg-blue-500/50 w-1/2 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Testimonials -->
                <div class="group bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-300">Testimonials</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Testimonial::count() }}</p>
                                </div>
                            </div>
                            <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-blue-800/50 rounded-full overflow-hidden">
                            <div class="h-1 bg-blue-500/50 w-1/3 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="group bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-300">Messages</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Message::where('read', false)->count() }}</p>
                                    <span class="text-xs text-green-400">unread</span>
                                </div>
                            </div>
                            <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-blue-800/50 rounded-full overflow-hidden">
                            <div class="h-1 bg-blue-500/50 w-2/3 rounded-full"></div>
                        </div>
                    </div>
                </div>
                
                <!-- CV Files -->
                <div class="group bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-300">CV Files</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\CVFile::count() }}</p>
                                    @if(\App\Models\CVFile::where('is_active', true)->count() > 0)
                                    <span class="text-xs text-green-400">{{ \App\Models\CVFile::where('is_active', true)->count() }} active</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-blue-800/50 rounded-full overflow-hidden">
                            <div class="h-1 bg-blue-500/50 w-1/2 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="group bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-300">Contact Info</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-3xl font-bold text-white mt-1">{{ $counts['contactInfo'] ?? 0 }}</p>
                                    @if(isset($contactActive) && $contactActive)
                                    <span class="text-xs text-green-400">Active</span>
                                    @else
                                    <span class="text-xs text-yellow-400">Not Active</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-blue-800/50 rounded-full overflow-hidden">
                            <div class="h-1 bg-blue-500/50 w-{{ isset($contactActive) && $contactActive ? 'full' : '1/4' }} rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-blue-300">Quick Actions</h3>
                    <span class="px-3 py-1 text-xs bg-blue-800/50 text-slate-300 rounded-full">Primary actions</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- New Blog Post -->
                    <a href="{{ route('admin.blogs.create') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-1">New Blog Post</h4>
                                <p class="text-sm text-blue-300">Create a new blog entry</p>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                    </a>

                    <!-- Add Work -->
                    <a href="{{ route('admin.works.create') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-1">Add Portfolio Work</h4>
                                <p class="text-sm text-blue-300">Create a new portfolio item</p>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                    </a>
                    
                    <!-- Upload CV File -->
                    <a href="{{ route('admin.cv-files.create') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-1">Upload CV File</h4>
                                <p class="text-sm text-blue-300">Add a new CV document</p>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                    </a>

                    <!-- Messages -->
                    <a href="{{ route('admin.messages.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-1">Check Messages</h4>
                                <p class="text-sm text-blue-300">View and respond to messages</p>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                    </a>
                    
                    <!-- Contact Information -->
                    <a href="{{ route('admin.contact-information.edit') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-1">Update Contact Info</h4>
                                <p class="text-sm text-blue-300">Edit contact details</p>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                    </a>
                </div>
            </div>

            <!-- Content Management -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-blue-300">Content Management</h3>
                        <span class="px-3 py-1 text-xs bg-blue-800/50 text-slate-300 rounded-full">All modules</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- About Me -->
                        <a href="{{ route('admin.about.edit') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">About Me</h4>
                                    <p class="text-sm text-blue-300">Manage your personal information</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Blogs -->
                        <a href="{{ route('admin.blogs.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Blogs</h4>
                                    <p class="text-sm text-blue-300">Manage your blog posts</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Works -->
                        <a href="{{ route('admin.works.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Works</h4>
                                    <p class="text-sm text-blue-300">Manage portfolio projects</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Testimonials -->
                        <a href="{{ route('admin.testimonials.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Testimonials</h4>
                                    <p class="text-sm text-blue-300">Manage client testimonials</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Hero Slides -->
                        <a href="{{ route('admin.hero-slides.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Hero Slides</h4>
                                    <p class="text-sm text-blue-300">Manage homepage hero section</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Navigation -->
                        <a href="{{ route('admin.navigation.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Navigation</h4>
                                    <p class="text-sm text-blue-300">Manage website navigation</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Location -->
                        <a href="{{ route('admin.location.edit') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Location</h4>
                                    <p class="text-sm text-blue-300">Update contact information</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Contact Information -->
                        <a href="{{ route('admin.contact-information.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Contact Information</h4>
                                    <p class="text-sm text-blue-300">Manage contact details</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Coming Soon -->
                        <a href="{{ route('admin.coming-soon.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Coming Soon</h4>
                                    <p class="text-sm text-blue-300">Manage upcoming features</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>

                        <!-- Zhyar CV -->
                        <a href="{{ route('admin.zhyar-cv.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">Zhyar CV</h4>
                                    <p class="text-sm text-blue-300">Manage CV information</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>
                        
                        <!-- CV Files -->
                        <a href="{{ route('admin.cv-files.index') }}" class="group relative bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50 hover:bg-blue-900/95">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="p-3 bg-blue-800/50 rounded-xl group-hover:bg-blue-800/70 transition-colors">
                                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m-3-3h6" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white mb-1">CV Files</h4>
                                    <p class="text-sm text-blue-300">Manage CV file uploads</p>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                        </a>
                    </div>
                </div>

                <!-- Recent Conversations -->
                <div class="lg:col-span-1 bg-blue-900/90 backdrop-blur-xl p-6 rounded-2xl border border-blue-700/50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-blue-300">Recent Conversations</h3>
                        <a href="{{ route('chat.index') }}" class="text-sm text-blue-400 hover:text-blue-300">View All</a>
                    </div>
                    
                    @if($recentConversations->isEmpty())
                        <div class="text-center py-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-blue-300/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-400">No recent conversations</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($recentConversations as $conversation)
                                <a href="{{ route('chat.show', $conversation) }}" class="block group bg-blue-800/50 hover:bg-blue-800/70 p-3 rounded-lg border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-[#4b0600] to-[#FF750F] flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($conversation->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-white truncate">{{ $conversation->user->name }}</p>
                                                @if($conversation->hasUnreadMessagesForAdmin())
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#FF750F] text-white">
                                                        New
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-blue-300 truncate">
                                                @if($conversation->latestMessage)
                                                    {{ $conversation->latestMessage->is_admin ? 'You: ' : 'User: ' }}
                                                    {{ \Illuminate\Support\Str::limit($conversation->latestMessage->message, 40) }}
                                                @else
                                                    No messages yet
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 