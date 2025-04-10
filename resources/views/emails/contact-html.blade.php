<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #4b0600 0%, #FF750F 100%);
            color: #ffffff;
            padding: 30px 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px;
        }
        .info-box {
            margin-bottom: 30px;
            background-color: #f5f5f5;
            border-radius: 6px;
            padding: 20px;
        }
        .info-label {
            font-weight: 600;
            color: #FF750F;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 16px;
            margin: 0;
            padding: 0;
        }
        .message-box {
            background-color: #f5f5f5;
            border-radius: 6px;
            padding: 25px;
            border-left: 4px solid #FF750F;
        }
        .message-text {
            margin: 0;
            font-size: 16px;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 20px 40px;
            text-align: center;
            color: #777;
            font-size: 14px;
            border-top: 1px solid #eeeeee;
        }
        .timestamp {
            color: #aaa;
            font-size: 13px;
            margin-top: 15px;
            text-align: right;
        }
        @media only screen and (max-width: 620px) {
            .container {
                width: 100%;
                border-radius: 0;
            }
            .header, .content, .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Message</h1>
            <p>You have received a new message from your website contact form</p>
        </div>
        
        <div class="content">
            <div class="info-box">
                <span class="info-label">From</span>
                <h3 class="info-value">{{ $name }}</h3>
                <span class="info-label">Email</span>
                <p class="info-value"><a href="mailto:{{ $email }}" style="color: #FF750F; text-decoration: none;">{{ $email }}</a></p>
                <span class="info-label">Subject</span>
                <p class="info-value">{{ $subject }}</p>
            </div>
            
            <span class="info-label">Message</span>
            <div class="message-box">
                <p class="message-text">{{ $message }}</p>
            </div>
            
            <p class="timestamp">Sent on {{ $date }}</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Portfolio Website | All rights reserved.</p>
            <p>This is an automated email sent from your contact form.</p>
        </div>
    </div>
</body>
</html> 