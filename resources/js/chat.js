// Chat polling system for real-time updates without page refresh
document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const POLLING_INTERVAL = 5000; // Poll every 5 seconds
    
    // Get elements
    const conversationsContainer = document.getElementById('conversations-container');
    const messagesContainer = document.getElementById('messages-container');
    const conversationId = messagesContainer ? messagesContainer.getAttribute('data-conversation-id') : null;
    
    // Polling functions
    function pollForNewConversations() {
        if (!conversationsContainer) return;
        
        fetch('/chat/poll-conversations')
            .then(response => response.json())
            .then(data => {
                if (data.html !== conversationsContainer.innerHTML) {
                    conversationsContainer.innerHTML = data.html;
                }
            })
            .catch(error => console.error('Error polling conversations:', error));
    }
    
    function pollForNewMessages() {
        if (!messagesContainer || !conversationId) return;
        
        fetch(`/chat/${conversationId}/poll-messages`)
            .then(response => response.json())
            .then(data => {
                if (data.html !== messagesContainer.innerHTML) {
                    messagesContainer.innerHTML = data.html;
                    // Scroll to bottom when new messages arrive
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    
                    // Mark messages as read
                    fetch(`/chat/${conversationId}/mark-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        }
                    });
                }
            })
            .catch(error => console.error('Error polling messages:', error));
    }
    
    // Start polling
    if (conversationsContainer) {
        setInterval(pollForNewConversations, POLLING_INTERVAL);
    }
    
    if (messagesContainer && conversationId) {
        setInterval(pollForNewMessages, POLLING_INTERVAL);
    }
    
    // Check for unread messages in the navbar
    const unreadBadge = document.getElementById('unread-message-count');
    const mobileUnreadBadge = document.getElementById('mobile-unread-message-count');
    
    function updateUnreadCount() {
        fetch('/chat/unread-count')
            .then(response => response.json())
            .then(data => {
                const count = data.count;
                if (count > 0) {
                    if (unreadBadge) {
                        unreadBadge.textContent = count;
                        unreadBadge.classList.remove('hidden');
                    }
                    if (mobileUnreadBadge) {
                        mobileUnreadBadge.textContent = count;
                        mobileUnreadBadge.classList.remove('hidden');
                    }
                } else {
                    if (unreadBadge) unreadBadge.classList.add('hidden');
                    if (mobileUnreadBadge) mobileUnreadBadge.classList.add('hidden');
                }
            })
            .catch(error => console.error('Error updating unread count:', error));
    }
    
    // Update unread count every 10 seconds
    setInterval(updateUnreadCount, 10000);
    updateUnreadCount(); // Initial check
}); 