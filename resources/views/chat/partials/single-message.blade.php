@php 
    if (!isset($isCurrentUser)) {
        $isCurrentUser = $message->is_admin == Auth::user()->is_admin;
    }
    $timeFormatted = $message->created_at->diffForHumans();
    $userName = $message->is_admin ? 'Admin' : $message->conversation->user->name;
    $initial = $message->is_admin ? 'A' : strtoupper(substr($message->conversation->user->name, 0, 1));
@endphp

<div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }} group message-item" data-message-id="{{ $message->id }}">
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