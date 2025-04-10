<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Conversations') }}
            </h2>
            <a href="{{ route('chat.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 rounded-lg font-semibold text-sm text-white shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ __('New Message') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Search bar -->
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                type="search" 
                                id="conversation-search" 
                                class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" 
                                placeholder="Search conversations..." 
                            />
                        </div>
                    </div>
                    <!-- Add a loading indicator and AJAX container -->
                    <div id="conversations-container">
                        @include('chat.partials.conversation-list', ['conversations' => $conversations])
                    </div>
                    <div id="loading-indicator" class="hidden flex justify-center my-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Start polling for new conversations
            startPollingConversations();
            
            // Search functionality
            const searchInput = document.getElementById('conversation-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    filterConversations(searchTerm);
                });
            }
        });

        function filterConversations(searchTerm) {
            const conversationItems = document.querySelectorAll('#conversation-list > div > a');
            
            conversationItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function startPollingConversations() {
            // Poll every 10 seconds
            setInterval(function() {
                fetch('{{ route('chat.poll-conversations') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            document.getElementById('conversation-list').innerHTML = data.html;
                            
                            // Re-apply any active search filter
                            const searchInput = document.getElementById('conversation-search');
                            if (searchInput && searchInput.value) {
                                filterConversations(searchInput.value.toLowerCase());
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error polling conversations:', error);
                    });
            }, 10000);
        }

        let page = 1;
        let loading = false;
        const conversationsContainer = document.getElementById('conversations-container');
        const loadingIndicator = document.getElementById('loading-indicator');
        
        // Load more conversations when scrolling to bottom
        window.addEventListener('scroll', function() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100) {
                if (!loading) {
                    loadMoreConversations();
                }
            }
        });
        
        function loadMoreConversations() {
            loading = true;
            page++;
            loadingIndicator.classList.remove('hidden');
            
            fetch(`{{ route('chat.index') }}?page=${page}&ajax=1`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                loading = false;
                loadingIndicator.classList.add('hidden');
                
                if (data.html) {
                    conversationsContainer.insertAdjacentHTML('beforeend', data.html);
                }
            })
            .catch(error => {
                console.error('Error loading more conversations:', error);
                loading = false;
                loadingIndicator.classList.add('hidden');
            });
        }
        
        // Auto-refresh conversations list
        setInterval(function() {
            refreshConversationsList();
        }, 30000); // every 30 seconds
        
        function refreshConversationsList() {
            fetch('{{ route('chat.poll-conversations') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        // Only update if user hasn't scrolled down to other pages
                        if (page === 1) {
                            conversationsContainer.innerHTML = data.html;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error refreshing conversations:', error);
                });
        }
    </script>
    @endpush
</x-app-layout> 