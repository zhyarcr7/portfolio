@if($messages->isEmpty())
    <div class="flex flex-col items-center justify-center h-full py-10">
        <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-4 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100">No messages yet</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Start the conversation by sending a message.</p>
    </div>
@else
    <div class="space-y-3 px-1">
        @foreach($messages as $message)
            @php 
                $isCurrentUser = $message->is_admin == Auth::user()->is_admin;
                $timeFormatted = $message->created_at->diffForHumans();
                $userName = $message->is_admin ? 'Admin' : $message->conversation->user->name;
                $initial = $message->is_admin ? 'A' : strtoupper(substr($message->conversation->user->name, 0, 1));
            @endphp
            
            <div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }} group">
                <div class="flex max-w-[75%]">
                    @if(!$isCurrentUser)
                        <div class="flex-shrink-0 mr-3 self-end">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-r from-indigo-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ $initial }}
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex flex-col">
                        @if(!$isCurrentUser)
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-1 mb-1">{{ $userName }}</span>
                        @endif
                        <div class="{{ $isCurrentUser 
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' 
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100' }} 
                            py-2 px-4 rounded-2xl {{ $isCurrentUser ? 'rounded-tr-sm' : 'rounded-tl-sm' }}">
                            <div class="whitespace-pre-wrap break-words text-sm">{{ $message->message }}</div>
                        </div>
                        <div class="flex items-center mt-1 {{ $isCurrentUser ? 'justify-end' : 'justify-start' }}">
                            <span class="text-xs text-gray-400 dark:text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ $timeFormatted }}
                            </span>
                        </div>
                    </div>
                    
                    @if($isCurrentUser)
                        <div class="flex-shrink-0 ml-3 self-end">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-r from-blue-600 to-indigo-500 flex items-center justify-center text-white font-semibold text-sm">
                                {{ $initial }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif 