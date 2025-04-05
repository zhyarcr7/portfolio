@if($conversations->isEmpty())
    <div class="flex flex-col items-center justify-center py-12">
        <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-5 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100">No messages yet</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400 text-center max-w-sm">Start a new conversation by clicking the "New Message" button.</p>
        <div class="mt-6">
            <a href="{{ route('chat.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 rounded-lg font-semibold text-sm text-white shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ __('Start a New Conversation') }}
            </a>
        </div>
    </div>
@else
    <div class="divide-y divide-gray-200 dark:divide-gray-700 -mx-4 sm:-mx-6">
        @foreach($conversations as $conversation)
            @php 
                $hasUnread = Auth::user()->is_admin ? $conversation->hasUnreadMessagesForAdmin() : $conversation->hasUnreadMessagesForUser();
                $lastMessageTime = $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : $conversation->created_at->diffForHumans();
                $userName = Auth::user()->is_admin ? $conversation->user->name : 'Admin';
                $initial = Auth::user()->is_admin ? strtoupper(substr($conversation->user->name, 0, 1)) : 'A';
            @endphp
            
            <a href="{{ route('chat.show', $conversation) }}" class="flex p-4 sm:p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out relative {{ $hasUnread ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">
                <!-- Left border for unread indicator -->
                @if($hasUnread)
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                @endif
                
                <div class="flex-shrink-0 mr-4">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-sm">
                        {{ $initial }}
                    </div>
                </div>
                
                <div class="min-w-0 flex-1">
                    <div class="flex justify-between items-baseline mb-1">
                        <h4 class="text-base font-medium text-gray-900 dark:text-white truncate">
                            {{ $conversation->title ?? $userName }}
                        </h4>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $lastMessageTime }}
                            </span>
                            @if($hasUnread)
                                <span class="ml-2 inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-xs font-medium text-white">
                                    <span class="sr-only">New messages</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        @if($conversation->latestMessage)
                            <p class="truncate">
                                @if(Auth::user()->is_admin && !$conversation->latestMessage->is_admin)
                                    <span class="font-medium text-gray-600 dark:text-gray-300">{{ $conversation->user->name }}:</span>
                                @elseif(!Auth::user()->is_admin && $conversation->latestMessage->is_admin)
                                    <span class="font-medium text-gray-600 dark:text-gray-300">Admin:</span>
                                @elseif(Auth::user()->is_admin && $conversation->latestMessage->is_admin)
                                    <span class="font-medium text-gray-600 dark:text-gray-300">You:</span>
                                @else
                                    <span class="font-medium text-gray-600 dark:text-gray-300">You:</span>
                                @endif
                                {{ \Illuminate\Support\Str::limit($conversation->latestMessage->message, 60) }}
                            </p>
                        @else
                            <p class="italic">No messages yet</p>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif 