<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Message Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #4b0600 0%, #FF750F 100%);
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .message {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #FF750F;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #4b0600 0%, #FF750F 100%);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Message Notification</h1>
    </div>
    <div class="content">
        <p>Hello,</p>
        <p>You have received a new message from <strong>{{ $sender }}</strong>:</p>
        
        <div class="message">
            {{ $messageContent }}
        </div>
        
        <p>To respond to this message, please log in to your account and visit your message inbox.</p>
        
        <a href="{{ url('/chat/show/' . $conversation->id) }}" class="button">View Message</a>
        
        <p>Thank you,<br>{{ config('app.name') }} Team</p>
    </div>
</body>
</html> 