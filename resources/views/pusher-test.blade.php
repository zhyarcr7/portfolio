<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pusher Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .status {
            margin-bottom: 20px;
        }
        .message-form {
            display: flex;
            margin-bottom: 20px;
        }
        .message-form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
        }
        .message-form button {
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        .messages {
            border: 1px solid #eee;
            border-radius: 4px;
            padding: 10px;
            height: 300px;
            overflow-y: auto;
        }
        .message {
            padding: 10px;
            margin-bottom: 5px;
            background: #f1f1f1;
            border-radius: 4px;
        }
        h1 {
            color: #333;
        }
        .debug {
            margin-top: 20px;
            background: #f8f8f8;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
        }
        .info {
            margin-top: 20px;
            padding: 10px;
            background: #e3f2fd;
            border-radius: 4px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Pusher Test</h1>
    
    <div class="container">
        <div class="status">
            <h3>Connection Status: <span id="connection-state">connecting...</span></h3>
        </div>
        
        <div class="message-form">
            <input type="text" id="message-input" placeholder="Type a message...">
            <button onclick="sendTestMessage()">Send</button>
        </div>
        
        <h3>Messages:</h3>
        <div id="messages" class="messages"></div>
    </div>
    
    <div class="info">
        <h3>Pusher Configuration:</h3>
        <p>App Key: {{ env('PUSHER_APP_KEY') }}</p>
        <p>Cluster: {{ env('PUSHER_APP_CLUSTER') }}</p>
        <p>Channel: chat</p>
        <p>Event: message</p>
    </div>
    
    <div class="debug">
        <h3>Debug Console:</h3>
        <div id="debug-console"></div>
    </div>
    
    
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ asset('js/pusher-test.js') }}"></script>
    <script>
        // Additional debug logging
        console.log = (function(originalConsoleLog) {
            return function() {
                const debugConsole = document.getElementById('debug-console');
                const args = Array.from(arguments);
                const message = args.map(arg => {
                    if (typeof arg === 'object') {
                        return JSON.stringify(arg, null, 2);
                    }
                    return arg;
                }).join(' ');
                
                const logElement = document.createElement('div');
                logElement.textContent = `${new Date().toLocaleTimeString()}: ${message}`;
                debugConsole.appendChild(logElement);
                
                originalConsoleLog.apply(console, arguments);
            };
        })(console.log);
        
        console.error = (function(originalConsoleError) {
            return function() {
                const debugConsole = document.getElementById('debug-console');
                const args = Array.from(arguments);
                const message = args.map(arg => {
                    if (typeof arg === 'object') {
                        return JSON.stringify(arg, null, 2);
                    }
                    return arg;
                }).join(' ');
                
                const logElement = document.createElement('div');
                logElement.textContent = `ERROR ${new Date().toLocaleTimeString()}: ${message}`;
                logElement.style.color = 'red';
                debugConsole.appendChild(logElement);
                
                originalConsoleError.apply(console, arguments);
            };
        })(console.error);
    </script>
</body>
</html> 