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
    <div class="space-y-3 px-1" id="messages-container">
        @foreach($messages->reverse() as $message)
            @include('chat.partials.single-message', ['message' => $message])
        @endforeach
    </div>
@endif 