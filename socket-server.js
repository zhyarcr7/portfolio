const { createServer } = require('http');
const { Server } = require('socket.io');

const httpServer = createServer();
const io = new Server(httpServer, {
  cors: {
    origin: "http://localhost:8000", // Your Laravel app URL
    methods: ["GET", "POST"],
    credentials: true
  }
});

// Store active users
const activeUsers = {};

// Listen for connection events
io.on('connection', (socket) => {
  console.log('New client connected', socket.id);
  
  // Handle user joining a chat room
  socket.on('join-chat', (data) => {
    const { userId, conversationId } = data;
    console.log(`User ${userId} joined conversation ${conversationId}`);
    
    // Store user info
    activeUsers[socket.id] = { userId, conversationId };
    
    // Join the room for this conversation
    socket.join(`chat.${conversationId}`);
    
    // Notify others that user has joined
    socket.to(`chat.${conversationId}`).emit('user-joined', { userId });
  });
  
  // Handle new messages
  socket.on('send-message', (data) => {
    const { conversationId, message, html } = data;
    console.log(`Message sent to conversation ${conversationId}:`, message);
    
    // Broadcast to all users in the conversation except sender
    socket.to(`chat.${conversationId}`).emit('new-message', { 
      conversationId,
      message,
      html,
      timestamp: new Date()
    });
  });
  
  // Handle typing indicator
  socket.on('typing', (data) => {
    const { conversationId, userId, isTyping } = data;
    socket.to(`chat.${conversationId}`).emit('user-typing', { userId, isTyping });
  });
  
  // Handle disconnect
  socket.on('disconnect', () => {
    const userData = activeUsers[socket.id];
    if (userData) {
      const { userId, conversationId } = userData;
      console.log(`User ${userId} disconnected from conversation ${conversationId}`);
      
      // Notify others that user has left
      socket.to(`chat.${conversationId}`).emit('user-left', { userId });
      
      // Remove user from active users
      delete activeUsers[socket.id];
    }
    console.log('Client disconnected', socket.id);
  });
});

// Start the server
const PORT = process.env.SOCKET_PORT || 3000;
httpServer.listen(PORT, () => {
  console.log(`Socket.io server running on port ${PORT}`);
}); 