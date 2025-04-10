// Pusher test script
const pusherAppKey = '9eb815e9fff03d0736be';
const pusherCluster = 'mt1';

// Create Pusher instance
const pusher = new Pusher(pusherAppKey, {
  cluster: pusherCluster,
  forceTLS: true
});

// Subscribe to the channel
const channel = pusher.subscribe('chat');

// Bind to connection state changes
pusher.connection.bind('state_change', function(states) {
  console.log('Pusher connection state changed:', states);
  document.getElementById('connection-state').innerText = states.current;
});

// Connected handler
pusher.connection.bind('connected', function() {
  console.log('Pusher connected successfully');
  document.getElementById('connection-state').innerText = 'connected';
  document.getElementById('connection-state').style.color = 'green';
});

// Error handler
pusher.connection.bind('error', function(error) {
  console.error('Pusher connection error:', error);
  document.getElementById('connection-state').innerText = 'error: ' + JSON.stringify(error);
  document.getElementById('connection-state').style.color = 'red';
});

// Listen for messages on the channel
channel.bind('message', function(data) {
  console.log('Received message:', data);
  const messagesDiv = document.getElementById('messages');
  const messageElement = document.createElement('div');
  messageElement.textContent = data.message;
  messageElement.className = 'message';
  messagesDiv.appendChild(messageElement);
});

// Function to send a test message
function sendTestMessage() {
  fetch('/api/send-test-message', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      message: document.getElementById('message-input').value
    })
  })
  .then(response => response.json())
  .then(data => {
    console.log('Message sent:', data);
    document.getElementById('message-input').value = '';
  })
  .catch(error => {
    console.error('Error sending message:', error);
  });
} 