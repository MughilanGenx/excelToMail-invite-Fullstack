<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            padding: 40px 40px 32px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0 0 6px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            margin: 0;
        }
        .body {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 16px;
        }
        .message {
            font-size: 15px;
            line-height: 1.75;
            color: #475569;
            white-space: pre-line;
        }
        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 32px 0;
        }
        .footer {
            background: #f8fafc;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            font-size: 12px;
            color: #94a3b8;
            margin: 4px 0;
        }
        .footer strong { color: #64748b; }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <h1>✉️ {{ $emailSubject }}</h1>
            <p>From {{ $fromName }}</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">Hello,</p>
            <p class="message">{{ $emailBody }}</p>

            <div class="divider"></div>

            <p style="font-size:13px;color:#94a3b8;margin:0;">
                This email was sent to you as part of our invitation list.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ $fromName }}</strong></p>
            <p>This is an automated invitation email. Please do not reply directly.</p>
        </div>
    </div>
</body>
</html>
