<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('chat.index') }}" class="mr-4 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @if(Auth::user()->is_admin)
                    {{ $conversation->title ?? 'Conversation with ' . $conversation->user->name }}
                @else
                    {{ $conversation->title ?? 'Conversation with Admin' }}
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Messages container with fixed height -->
                    <div id="message-list" class="h-[60vh] overflow-y-auto mb-4 custom-scrollbar">
                        @include('chat.partials.message-list')
                    </div>
                    
                    <!-- Message form with improved styling -->
                    <form id="message-form" action="{{ route('chat.messages.store', $conversation) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="relative">
                            <textarea 
                                id="message-input" 
                                name="message" 
                                rows="2" 
                                class="w-full pr-14 pl-4 py-3 rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm resize-none"
                                placeholder="Type your message..."
                            ></textarea>
                            <button 
                                type="submit" 
                                class="absolute right-3 bottom-3 inline-flex justify-center items-center p-2 bg-gradient-to-r from-blue-600 to-indigo-500 rounded-full text-white shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to bottom of messages on load
            scrollToBottom();
            
            // Start polling for new messages
            startPollingMessages();
            
            // Handle form submission with AJAX
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                
                if (message) {
                    const formData = new FormData(messageForm);
                    
                    fetch(messageForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Clear input field
                            messageInput.value = '';
                            messageInput.style.height = 'auto';
                            
                            // Refresh message list
                            refreshMessages();
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                    });
                }
            });
            
            // Auto-resize textarea as user types
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
        
        function scrollToBottom() {
            const messageList = document.getElementById('message-list');
            messageList.scrollTop = messageList.scrollHeight;
        }
        
        function startPollingMessages() {
            // Poll every 5 seconds
            setInterval(function() {
                refreshMessages();
            }, 5000);
        }
        
        function refreshMessages() {
            fetch('{{ route('chat.poll-messages', $conversation) }}')
                .then(response => response.json())
                .then(data => {
                    const messageList = document.getElementById('message-list');
                    const shouldScroll = messageList.scrollTop + messageList.clientHeight >= messageList.scrollHeight - 50;
                    
                    // Update the HTML only if there's new content
                    if (data.html) {
                        messageList.innerHTML = data.html;
                    }
                    
                    // Scroll to bottom if we were already at the bottom
                    if (shouldScroll) {
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error polling messages:', error);
                });
        }
    </script>
    @endpush
    
    @push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 20px;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(75, 85, 99, 0.5);
        }
    </style>
    @endpush
</x-app-layout> 