<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-white leading-tight">
                {{ __('Message Dashboard') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-green-500/10 text-green-500 rounded-full border border-green-500/20">Messages</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl mb-6 border border-blue-700/50">
                <div class="p-6 flex items-center justify-between relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-white mb-2">Welcome back, {{ Auth::user()->name }}</h3>
                        <p class="text-slate-300">Stay in touch with the admin through this messaging system</p>
                        <div class="mt-4">
                            <a href="{{ route('chat.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#FF750F] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Start New Conversation
                            </a>
                        </div>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-blue-800/20 to-transparent"></div>
                </div>
            </div>

            <!-- Conversations List -->
            <div class="bg-white dark:bg-blue-900/90 backdrop-blur-xl overflow-hidden rounded-2xl border border-blue-700/50">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-blue-300">Your Messages</h3>
                        <span class="px-3 py-1 text-xs bg-blue-800/50 text-slate-300 rounded-full">Recent conversations</span>
                    </div>

                    @php
                        $conversations = Auth::user()->conversations()
                            ->with(['latestMessage'])
                            ->orderBy('last_message_at', 'desc')
                            ->get();
                    @endphp

                    @if($conversations->isEmpty())
                        <div class="text-center py-8 text-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-blue-300/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <h3 class="mt-2 text-xl font-medium text-white">No messages yet</h3>
                            <p class="mt-1 text-gray-400">Start a new conversation with the admin</p>
                            <div class="mt-6">
                                <a href="{{ route('chat.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#4b0600] to-[#FF750F] rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#FF750F] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Start a New Conversation
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('chat.show', $conversation) }}" class="block group relative bg-blue-800/50 hover:bg-blue-800/70 backdrop-blur-xl p-4 rounded-2xl border border-blue-700/50 transition-all duration-300 hover:border-blue-500/50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-4">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-r from-[#4b0600] to-[#FF750F] flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="text-lg font-semibold text-white truncate">
                                                    {{ $conversation->title ?? 'Conversation with Admin' }}
                                                </h4>
                                                <span class="text-xs text-blue-300">
                                                    {{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : $conversation->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-blue-300 truncate">
                                                @if($conversation->latestMessage)
                                                    {{ $conversation->latestMessage->is_admin ? 'Admin: ' : 'You: ' }}
                                                    {{ \Illuminate\Support\Str::limit($conversation->latestMessage->message, 50) }}
                                                @else
                                                    No messages yet
                                                @endif
                                            </p>
                                        </div>
                                        @if($conversation->hasUnreadMessagesForUser())
                                            <div class="ml-3">
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-[#FF750F] text-white text-xs font-semibold">
                                                    New
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-700 group-hover:w-full transition-all duration-300 rounded-b-2xl"></div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
