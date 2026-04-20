<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            line-height: 1.6;
        }
        .wrapper   { max-width: 600px; margin: 30px auto; padding: 16px; }
        .container { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a252f 0%, #2980b9 100%);
            padding: 36px 30px 32px;
            text-align: center;
        }
        .logo        { font-size: 26px; font-weight: bold; color: #ffffff; letter-spacing: 1px; margin-bottom: 4px; }
        .logo span   { color: #f39c12; }
        .tagline     { font-size: 13px; color: rgba(255,255,255,0.7); }
        .live-badge  {
            display: inline-block; margin-top: 16px;
            background: #ffffff; color: #27ae60;
            font-size: 11px; font-weight: bold;
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 5px 18px; border-radius: 50px;
        }

        /* Body */
        .body        { padding: 40px 36px; }
        .rocket      { font-size: 52px; text-align: center; margin-bottom: 8px; }
        .title       { font-size: 26px; font-weight: bold; color: #2c3e50; text-align: center; margin-bottom: 24px; }
        .greeting    { font-size: 16px; color: #444; margin-bottom: 14px; }
        .name-hi     { color: #2980b9; font-weight: bold; }
        .message     { font-size: 15px; color: #555; margin-bottom: 18px; line-height: 1.75; }

        /* Highlights box */
        .highlights  {
            background: #eaf4fb; border-left: 4px solid #3498db;
            border-radius: 6px; padding: 18px 22px; margin: 22px 0;
        }
        .highlights h3 { color: #2c3e50; font-size: 15px; margin-bottom: 10px; }
        .highlights ul { padding-left: 18px; font-size: 14px; color: #444; }
        .highlights ul li { margin-bottom: 8px; }

        /* Store badges wrapper */
        .badges-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #2c3e50;
            margin: 28px 0 16px;
        }
        .badges-row  { text-align: center; margin-bottom: 10px; }
        .badges-row a { display: inline-block; margin: 0 8px; }
        .badges-row img { height: 52px; border-radius: 8px; vertical-align: middle; }

        .divider     { height: 1px; background: #eeeeee; margin: 28px 0; }

        /* Footer */
        .footer      {
            background: #f9f9f9; border-top: 1px solid #eee;
            padding: 22px 36px; text-align: center;
        }
        .footer .brand  { font-size: 15px; font-weight: bold; color: #2c3e50; margin-bottom: 6px; }
        .footer p    { font-size: 13px; color: #999; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrapper">
<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <div class="logo">Task <span>Concierge</span></div>
        <div class="tagline">Your Trusted Task Platform</div>
        <div class="live-badge">🎉 App Now Live</div>
    </div>

    {{-- BODY --}}
    <div class="body">
        <div class="rocket">🚀</div>
        <h1 class="title">We're Live! Welcome Aboard.</h1>

        {{-- Greeting — show name if available, otherwise fall back to email --}}
        <p class="greeting">
            Hi <span class="name-hi">{{ $recipientName ?: $recipientEmail }}</span>,
        </p>

        <p class="message">{{ $emailBody }}</p>

        <p class="message">
            We're thrilled to announce that the <strong>Task Concierge</strong> app is officially live!
            Whether you're looking to get things done or offer your skills, our platform is designed
            to connect you with the right people at the right time.
        </p>

        {{-- Feature Highlights --}}
        <div class="highlights">
            <h3>✨ What you can do with Task Concierge:</h3>
            <ul>
                <li>📋 Post tasks and get them done quickly</li>
                <li>💼 Become a Tasker and earn on your schedule</li>
                <li>🔒 Safe, verified, and trusted community</li>
                <li>💬 In-app messaging and real-time updates</li>
            </ul>
        </div>

        {{-- App Store Badges --}}
        <p class="badges-title">📲 Download the App</p>
        <div class="badges-row">
            @if($appStoreLink && $appStoreLink !== '#')
            <a href="{{ $appStoreLink }}" target="_blank">
                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                     alt="Download on the App Store">
            </a>
            @endif

            @if($playStoreLink && $playStoreLink !== '#')
            <a href="{{ $playStoreLink }}" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                     alt="Get it on Google Play">
            </a>
            @endif
        </div>

        <div class="divider"></div>

        <p class="message" style="text-align:center;font-size:14px;color:#888;">
            We're excited to have you as one of our early members.<br>
            Be among the first to experience Task Concierge!
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="brand">Task Concierge</div>
        <p>Best regards,<br><strong>The {{ $fromName }} Team</strong></p>
        <p style="margin-top:10px;">
            If you received this by mistake, please ignore it.<br>
            You're receiving this because you signed up for our early access list.
        </p>
    </div>

</div>
</div>
</body>
</html>
