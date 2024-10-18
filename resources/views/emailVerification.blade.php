<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f7;
            color: #333;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            background-color: #2447d1;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .content h2 {
            font-size: 22px;
            color: #2447d1;
            margin-bottom: 10px;
        }
        .verification-code {
            background-color: #e8eaf6; 
            border: 1px dashed #6b5b93; 
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            display: inline-block;
        }
        .content p {
            font-size: 16px;
            color: #666;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #999;
        }
        .footer a {
            color: #6b5b93; 
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline; 
        }
    </style>
</head>
<body>

    <div class="container">

        <div class="header">
            <h1>Verification Code</h1>
        </div>
        
        <div class="content">
            <h2>Hello, {{ $user->name }}</h2>
            <p>Your verification code is:</p>
            <div class="verification-code">
                {{ $verificationCode ?? '' }}
            </div>
            <p>Do not share this code with anyone.</p>
        </div>

        <div class="footer">
            <p>If you did not request this email, you can safely ignore it. <br>
                If you have any questions, please <a href="mailto:support@cyclelink.com">contact our support team</a>.</p>             
        </div>
    </div>

</body>
</html>
