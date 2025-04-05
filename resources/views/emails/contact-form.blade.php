<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .message {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #FF750F;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
    </div>
    <div class="content">
        <p>You have received a new message from your website contact form:</p>
        
        <div class="field">
            <span class="field-label">Name:</span>
            {{ $data['name'] }}
        </div>
        
        <div class="field">
            <span class="field-label">Email:</span>
            <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
        </div>
        
        <div class="field">
            <span class="field-label">Subject:</span>
            {{ $data['subject'] }}
        </div>
        
        <div class="field">
            <span class="field-label">Message:</span>
            <div class="message">
                {{ $data['message'] }}
            </div>
        </div>
        
        <p>You can respond directly to this email to reply to the sender.</p>
    </div>
</body>
</html> 