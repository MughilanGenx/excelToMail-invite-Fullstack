<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TC Invitation Mail | Home</title>
    <!-- Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #030712;
            --surface-color: rgba(31, 41, 55, 0.4);
            --primary: #3b82f6;
            --primary-glow: rgba(59, 130, 246, 0.5);
            --secondary: #8b5cf6;
            --secondary-glow: rgba(139, 92, 246, 0.5);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(59, 130, 246, 0.15), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(139, 92, 246, 0.15), transparent 25%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Glassmorphic Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.25rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(3, 7, 18, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            z-index: 100;
        }

        .logo {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(to right, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--text-main);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 8rem 5% 4rem;
            text-align: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
            z-index: -1;
            pointer-events: none;
        }

        .badge {
            font-family: 'Outfit', sans-serif;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1.25rem;
            border-radius: 99px;
            margin-bottom: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #e2e8f0;
            animation: slideDown 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(-20px);
        }

        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(3rem, 6vw, 5.5rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.04em;
            margin-bottom: 1.5rem;
            max-width: 900px;
            animation: fadeInUp 1s ease-out 0.2s forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .hero h1 span {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: clamp(1.1rem, 2vw, 1.25rem);
            color: var(--text-muted);
            max-width: 600px;
            margin-bottom: 3rem;
            animation: fadeInUp 1s ease-out 0.4s forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .cta-group {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.6s forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .btn {
            font-family: 'Inter', sans-serif;
            padding: 1rem 2.5rem;
            border-radius: 99px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .btn-primary::before {
            content: "";
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.7s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 6px 25px var(--secondary-glow);
            transform: translateY(-2px);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-main);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Features Section */
        .features {
            padding: 5rem 5% 8rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .feature-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.5rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 1.2s ease-out 0.8s forwards;
            opacity: 0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(139, 92, 246, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .feature-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Animations keyframes */
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; } /* Simplified mobile nav */
            .hero p { padding: 0 1rem; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="/" class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            TC Mail
        </a>
        <div class="nav-links">
            <a href="/">Home</a>
            <a href="#features">Features</a>
            <a href="{{ route('excel.index') }}">Data Tools</a>
        </div>
    </nav>

    <main class="hero">
        <div class="badge">
            <span style="color: #60a5fa;">New</span> Data Extraction Tool is Live
        </div>
        
        <h1>Next-Gen Workflows <span>Automated.</span></h1>
        
        <p>A unified platform for intelligent data parsing and scalable email dispatches. Streamline your processes from Excel files to the inbox effortlessly.</p>
        
        <div class="cta-group">
            <a href="{{ route('excel.index') }}" class="btn btn-primary">
                Try Excel Extractor
            </a>
            <a href="#features" class="btn btn-secondary">
                Learn More
            </a>
        </div>
    </main>

    <section id="features" class="features">
        <div class="feature-card">
            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <h3>Smart Excel Parsing</h3>
            <p>Upload raw CSV and XLSX files. Our system automatically processes headers and extracts critical rows natively.</p>
        </div>

        <div class="feature-card" style="animation-delay: 1s;">
            <div class="icon-wrapper" style="color: #a855f7; background: rgba(168, 85, 247, 0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4"></circle>
                    <line x1="2" y1="12" x2="6" y2="12"></line>
                    <line x1="18" y1="12" x2="22" y2="12"></line>
                    <line x1="12" y1="2" x2="12" y2="6"></line>
                    <line x1="12" y1="18" x2="12" y2="22"></line>
                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                    <line x1="2.83" y1="16.24" x2="5.66" y2="13.41"></line>
                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                </svg>
            </div>
            <h3>High Performance</h3>
            <p>Powered by Laravel 12. Enjoy lightning-fast data visualizations without page reloads blocking your productivity.</p>
        </div>

        <div class="feature-card" style="animation-delay: 1.2s;">
            <div class="icon-wrapper" style="color: #ec4899; background: rgba(236, 72, 153, 0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <h3>Secure Infrastructure</h3>
            <p>Your data uploads are processed exclusively server-side with strict validation and protected logic gates.</p>
        </div>
    </section>

</body>
</html>
