<x-app-layout>
    <div class="h-screen bg-gray-900 flex">
        <!-- Main container with sidebar and conversation area -->
        <div class="w-full flex">
            <!-- Left side: Conversations List (Messenger style) -->
            <div class="w-[350px] flex flex-col border-r border-gray-700 bg-gray-800">
                <!-- Header with user info -->
                <div class="bg-gray-800 p-4 border-b border-gray-700 flex items-center justify-between">
        <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <h2 class="font-medium text-lg text-white">Chats</h2>
                    </div>
                    <a href="{{ route('chat.create') }}" class="p-2 bg-gray-700 rounded-full text-gray-300 hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </a>
                </div>
                
                <!-- Search box -->
                <div class="p-3 border-b border-gray-700">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="search-conversations" 
                            class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-700 text-gray-200 border-gray-600 focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="Search conversations..." 
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Conversations list -->
                <div id="conversations-list" class="flex-grow overflow-y-auto custom-scrollbar">
                    <!-- Check if there are any conversations -->
                    @if(isset($conversations) && $conversations->count() > 0)
                        <!-- Messenger-style conversation list -->
                        <div class="divide-y divide-gray-700">
                            @foreach($conversations as $conv)
                                @php 
                                    $isActive = isset($conversation) && $conversation->id == $conv->id;
                                    $hasUnread = Auth::user()->is_admin ? $conv->hasUnreadMessagesForAdmin() : $conv->hasUnreadMessagesForUser();
                                    $lastMessageTime = $conv->last_message_at ? $conv->last_message_at->diffForHumans() : $conv->created_at->diffForHumans();
                                    $userName = Auth::user()->is_admin ? ($conv->user->name ?? 'Unknown User') : 'Admin';
                                    $initial = Auth::user()->is_admin ? strtoupper(substr($conv->user->name ?? 'U', 0, 1)) : 'A';
                                @endphp
                                
                                <a href="{{ route('chat.show', $conv) }}" class="block hover:bg-gray-700 transition-colors {{ $isActive ? 'bg-gray-700' : '' }}">
                                    <div class="flex items-start p-3">
                                        <!-- Avatar -->
                                        <div class="relative flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                                {{ $initial }}
                                            </div>
                                            @if($hasUnread)
                                                <span class="absolute -top-1 -right-1 h-4 w-4 bg-blue-500 rounded-full"></span>
                                            @endif
                                        </div>
                                        
                                        <!-- Conversation info -->
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-100 truncate">{{ $userName }}</span>
                                                <span class="text-xs text-gray-400">{{ $lastMessageTime }}</span>
                                            </div>
                                            
                                            <!-- Last message preview -->
                                            <p class="text-sm text-gray-400 truncate mt-1">
                                                @if($conv->latestMessage)
                                                    @if(($conv->latestMessage->user_id == Auth::id()) == ($conv->latestMessage->is_admin == Auth::user()->is_admin))
                                                        <span class="text-gray-500">You: </span>
                                                    @endif
                                                    {{ \Illuminate\Support\Str::limit($conv->latestMessage->message, 40) }}
                                                @else
                                                    <span class="italic">No messages yet</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty state - No conversations -->
                        <div class="flex flex-col items-center justify-center h-full py-12 px-6 text-center">
                            <p class="text-gray-400 mb-4">No conversations found</p>
                            <a href="{{ route('chat.create') }}" class="py-2 px-6 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm">
                                Start a new conversation
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Right side: Conversation Area (main content) -->
            @if(isset($conversation))
                <div class="flex-1 flex flex-col">
                    <!-- Conversation Header -->
                    <div class="bg-gray-800 p-4 border-b border-gray-700 flex items-center">
                        <div class="flex items-center flex-1">
                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                @if(Auth::user()->is_admin)
                                    {{ strtoupper(substr($conversation->user->name ?? 'U', 0, 1)) }}
                                @else
                                    A
                                @endif
                            </div>
                            <div>
                                <h2 class="font-medium text-lg text-white">
                @if(Auth::user()->is_admin)
                                        {{ $conversation->user->name ?? 'Unknown User' }}
                @else
                                        Admin
                @endif
            </h2>
                                <!-- Online status indicator -->
                                <div class="flex items-center text-xs text-gray-400">
                                    <span class="h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                                    <span>Active now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Messages container -->
                    <div id="message-list" class="flex-grow overflow-y-auto bg-gray-900 custom-scrollbar">
                        <!-- Load more button at the bottom for older messages -->
                        <div id="messages-container" class="space-y-4 p-4">
                            @include('chat.partials.message-list')
                        </div>
                        
                        <!-- Loading indicator and load more button -->
                        <div id="loading-older-messages" class="flex justify-center mt-4 hidden">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                        </div>
                        
                        <button id="load-more-btn" class="w-full py-2 px-4 m-4 text-sm bg-gray-800 text-gray-300 rounded-md hover:bg-gray-700 transition-colors">
                            Load older messages
                        </button>
                    </div>
                    
                    <!-- Message form at bottom -->
                    <div class="p-4 bg-gray-800 border-t border-gray-700">
                        <form id="message-form" action="{{ route('chat.messages.store', $conversation) }}" method="POST">
                        @csrf
                        <div class="relative">
                            <textarea 
                                id="message-input" 
                                name="message" 
                                    rows="1" 
                                    class="w-full pr-14 pl-4 py-3 rounded-full bg-gray-700 text-gray-100 focus:ring-blue-500 focus:border-blue-500 border-gray-600 shadow-sm text-sm resize-none"
                                placeholder="Type your message..."
                            ></textarea>
                            <button 
                                type="submit" 
                                    class="absolute right-2 bottom-2 inline-flex justify-center items-center p-2 bg-blue-600 rounded-full text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
                <!-- No conversation selected state -->
                <div class="flex-1 flex items-center justify-center bg-gray-900">
                    <div class="text-center p-8">
                        <div class="bg-gray-800 rounded-full p-6 mb-4 mx-auto w-24 h-24 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-medium text-gray-200 mb-2">Your Messages</h2>
                        <p class="text-gray-400 mb-6">Select a conversation from the sidebar or start a new one</p>
                        <a href="{{ route('chat.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Start a new conversation
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Since messages are now in newest-first order, scroll to top instead
            const messageList = document.getElementById('message-list');
            if (messageList) {
                messageList.scrollTop = 0;
            }
            
            // Function to scroll to top of messages (for new messages)
            function scrollToTop() {
                const messageList = document.getElementById('message-list');
                if (messageList) {
                    messageList.scrollTop = 0;
                }
            }
            
            // Variables for paging
            let page = 1;
            let oldestMessageId = null;
            let loading = false;
            
            // Socket.io connection
            @if(isset($conversation))
            const socket = io('http://localhost:3000', {
                withCredentials: true
            });
            
            // When connected to socket server
            socket.on('connect', function() {
                console.log('Connected to Socket.io server with ID:', socket.id);
                
                // Join the conversation room
                socket.emit('join-chat', {
                    userId: {{ Auth::id() }},
                    conversationId: {{ $conversation->id }}
                });
            });
            
            // Handle socket connection error
            socket.on('connect_error', (error) => {
                console.error('Socket.io connection error:', error);
            });
            
            // Listen for new messages from other users
            socket.on('new-message', function(data) {
                console.log('New message received:', data);
                if (data.html) {
                    const messagesContainer = document.getElementById('messages-container');
                    messagesContainer.insertAdjacentHTML('beforeend', data.html);
                    scrollToTop();
                    markAsRead();
                }
            });
            
            // Listen for typing indicators
            socket.on('user-typing', function(data) {
                // Implement typing indicator if needed
                console.log('User typing:', data);
            });
            @endif
            
            // Load more button handler
            const loadMoreBtn = document.getElementById('load-more-btn');
            const loadingIndicator = document.getElementById('loading-older-messages');
            const messagesContainer = document.getElementById('messages-container');
            
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    if (loading) return;
                    
                    loading = true;
                    loadMoreBtn.style.display = 'none';
                    loadingIndicator.classList.remove('hidden');
                    
                    // Get oldest message ID for pagination
                    const allMessages = document.querySelectorAll('.message-item');
                    if (allMessages.length > 0) {
                        oldestMessageId = allMessages[allMessages.length - 1].dataset.messageId;
                    }
                    
                    // Fetch older messages
                    fetch(`{{ route('chat.show', $conversation) }}?before=${oldestMessageId}&ajax=1`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            // Append older messages at the bottom
                            messagesContainer.insertAdjacentHTML('beforeend', data.html);
                            
                            if (!data.hasMorePages) {
                                // No more messages to load
                                loadMoreBtn.style.display = 'none';
                            } else {
                                loadMoreBtn.style.display = 'block';
                            }
                        } else {
                            // No more messages
                            loadMoreBtn.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading more messages:', error);
                    })
                    .finally(() => {
                        loading = false;
                        loadingIndicator.classList.add('hidden');
                    });
                });
            }
            
            // Handle form submission with AJAX
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            
            if (messageForm && messageInput) {
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                
                if (message) {
                        // Show a temporary message immediately for better UX
                        const tempMessageHtml = `
                            <div class="flex justify-end group temp-message">
                                <div class="flex max-w-[75%]">
                                    <div class="flex flex-col">
                                        <div class="bg-blue-600 text-white py-2 px-4 rounded-2xl rounded-tr-sm">
                                            <div class="whitespace-pre-wrap break-words text-sm">${message}</div>
                                        </div>
                                        <div class="flex items-center mt-1 justify-end">
                                            <span class="text-xs text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                                Just now (sending...)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-3 self-end">
                                        <div class="h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        messagesContainer.insertAdjacentHTML('beforeend', tempMessageHtml);
                        scrollToTop();
                        
                        @if(isset($conversation))
                        // Send the message via AJAX
                    const formData = new FormData(messageForm);
                    
                    fetch(messageForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                    .then(data => {
                            // Remove temporary message
                            const tempMessages = document.querySelectorAll('.temp-message');
                            tempMessages.forEach(el => el.remove());
                            
                        if (data.success) {
                            // Clear input field
                            messageInput.value = '';
                            messageInput.style.height = 'auto';
                            
                                // Add the permanent message
                                messagesContainer.insertAdjacentHTML('beforeend', data.html);
                                scrollToTop();
                                
                                // Emit message via Socket.io
                                socket.emit('send-message', {
                                    conversationId: {{ $conversation->id }},
                                    message: message,
                                    html: data.html
                                });
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                            alert('Failed to send message. Please try again.');
                            
                            // Remove the temporary message if failed
                            const tempMessages = document.querySelectorAll('.temp-message');
                            tempMessages.forEach(el => el.remove());
                    });
                        @endif
                }
            });
            
            // Auto-resize textarea as user types
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                    
                    @if(isset($conversation))
                    // Emit typing indicator
                    socket.emit('typing', {
                        conversationId: {{ $conversation->id }},
                        userId: {{ Auth::id() }},
                        isTyping: true
                    });
                    @endif
                });
            }
            
            // Mark messages as read when the user opens the conversation
            @if(isset($conversation))
            markAsRead();
            @endif
        });
        
        function markAsRead() {
            @if(isset($conversation))
            fetch('{{ route('chat.mark-read', $conversation) }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .catch(error => {
                console.error('Error marking messages as read:', error);
            });
            @endif
        }
        
        // Function to create a new conversation
        function createNewConversation() {
            window.location.href = '{{ route('chat.create') }}';
        }
    </script>
    @endpush
    
    @push('styles')
    <style>
        /* Remove ALL scrollbars throughout the app */
        *::-webkit-scrollbar {
            width: 0 !important;
            height: 0 !important;
            display: none !important;
        }
        
        * {
            -ms-overflow-style: none !important;  /* IE and Edge */
            scrollbar-width: none !important;  /* Firefox */
        }
        
        /* Make sure textarea has no scrollbar */
        textarea {
            overflow: hidden;
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
        
        textarea::-webkit-scrollbar {
            display: none !important;
        }
        
        /* Ensure the message container and conversation list don't show scrollbars */
        #message-list, #conversations-list, #messages-container {
            overflow-y: auto;
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
        
        #message-list::-webkit-scrollbar, 
        #conversations-list::-webkit-scrollbar,
        #messages-container::-webkit-scrollbar {
            display: none !important;
        }
        
        /* Base styles for the entire page */
        body {
            background-color: #111827;
            color: #f3f4f6;
            overflow: hidden;
        }
        
        /* Message bubbles styling */
        .message-item {
            margin-bottom: 1rem;
        }
        
        .regular-user-label {
            display: block;
            font-size: 0.75rem;
            color: #9ca3af;
            margin-bottom: 0.25rem;
        }
        
        .message-bubble {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            max-width: 80%;
            word-break: break-word;
        }
        
        .user-message .message-bubble {
            background-color: #1e293b;
            color: #f3f4f6;
            border-bottom-left-radius: 0.25rem;
        }
        
        .admin-message .message-bubble {
            background-color: #2563eb;
            color: white;
            border-bottom-right-radius: 0.25rem;
        }
    </style>
    @endpush
</x-app-layout> 