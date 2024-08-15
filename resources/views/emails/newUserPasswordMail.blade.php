<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SIBA CAMPUS LMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }

        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #5cb85c;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            line-height: 1.6;
        }

        .content p {
            margin-bottom: 20px;
        }

        .user-details {
            background-color: #e9f9e9;
            border-left: 4px solid #5cb85c;
            padding: 10px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            color: #777777;
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to SIBA CAMPUS LMS, {{ $UserName }}!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $UserName }},</p>
            <p>We are excited to have you on board! Your account has been successfully created. Below are your login
                credentials:</p>
            <div class="user-details">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>
            <p>Please make sure to keep this information secure. You can log in to your account at any time using the
                credentials above.</p>
            <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
            <p>Best regards,<br>SIBA CAMPUS LMS Support Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 SIBA CAMPUS LMS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
