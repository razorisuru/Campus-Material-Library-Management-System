<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your PDF has been approved</title>
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

        .message {
            background-color: #e9f9e9;
            border-left: 4px solid #5cb85c;
            padding: 10px;
            margin: 20px 0;
            font-style: italic;
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
            <h1>{{ $pdfName }} PDF has been approved</h1>
        </div>
        <div class="content">
            <p>Dear {{ $UserName }},</p>
            <p>We are pleased to inform you that your submitted PDF document has been approved. The document meets all
                the required specifications and is now available in our system.</p>
            <div class="message">
                <p>Thank you for your submission. If you have any further documents or need assistance, please feel free
                    to reach out to our support team.</p>
            </div>
            <p>Best regards,<br>SIBA CAMPUS LMS Support Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 SIBA CAMPUS LMS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
