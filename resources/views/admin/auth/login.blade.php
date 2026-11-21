<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — CODEVA TECH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #000;
            color: #fff;
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ================================
           BACKGROUND LAYERS
        ================================ */

        /* Purple gradient top-to-bottom */
        .bg-gradient {
            position: fixed;
            inset: 0;
            background: linear-gradient(to bottom, rgba(168,85,247,0.4) 0%, rgba(126,34,206,0.5) 40%, #000 100%);
            pointer-events: none;
            z-index: 0;
        }

        /* Noise texture */
        .bg-noise {
            position: fixed;
            inset: 0;
            opacity: 0.03;
            mix-blend-mode: soft-light;
            pointer-events: none;
            z-index: 1;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 200px 200px;
        }

        /* Top radial glow */
        .bg-glow-top {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 120vh;
            height: 60vh;
            border-radius: 0 0 50% 50%;
            background: rgba(192, 132, 252, 0.2);
            filter: blur(80px);
            pointer-events: none;
            z-index: 1;
        }
        .bg-glow-top-pulse {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100vh;
            height: 60vh;
            border-radius: 0 0 50% 50%;
            background: rgba(216, 180, 254, 0.2);
            filter: blur(60px);
            pointer-events: none;
            z-index: 1;
            animation: pulseGlow 8s ease-in-out infinite alternate;
        }
        .bg-glow-bottom {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 90vh;
            height: 90vh;
            border-radius: 50% 50% 0 0;
            background: rgba(168, 85, 247, 0.2);
            filter: blur(60px);
            pointer-events: none;
            z-index: 1;
            animation: pulseGlowBottom 6s ease-in-out infinite alternate;
        }

        /* Animated white spots */
        .bg-spot-1 {
            position: fixed;
            left: 25%;
            top: 25%;
            width: 24rem;
            height: 24rem;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            filter: blur(100px);
            animation: pulseFade 4s ease-in-out infinite alternate;
            pointer-events: none;
            z-index: 1;
        }
        .bg-spot-2 {
            position: fixed;
            right: 25%;
            bottom: 25%;
            width: 24rem;
            height: 24rem;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            filter: blur(100px);
            animation: pulseFade 4s ease-in-out infinite alternate-reverse;
            animation-delay: 1s;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes pulseGlow {
            from { opacity: 0.15; transform: translateX(-50%) scale(0.98); }
            to   { opacity: 0.30; transform: translateX(-50%) scale(1.02); }
        }
        @keyframes pulseGlowBottom {
            from { opacity: 0.30; transform: translateX(-50%) scale(1.0); }
            to   { opacity: 0.50; transform: translateX(-50%) scale(1.1); }
        }
        @keyframes pulseFade {
            from { opacity: 0.3; }
            to   { opacity: 0.6; }
        }

        /* ================================
           CARD WRAPPER (3D perspective)
        ================================ */
        .card-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 384px;
            padding: 0 1rem;
            perspective: 1500px;
            animation: cardEntrance 0.8s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes cardEntrance {
            to { opacity: 1; transform: translateY(0); }
        }

        .card-3d {
            transition: transform 0.12s ease-out;
            transform-style: preserve-3d;
        }

        /* ================================
           CARD GROUP — traveling light beams
        ================================ */
        .card-group {
            position: relative;
        }

        /* Animated border glow on hover */
        .card-glow-ring {
            position: absolute;
            inset: -1px;
            border-radius: 1rem;
            background: linear-gradient(to right, rgba(255,255,255,0.03), rgba(255,255,255,0.07), rgba(255,255,255,0.03));
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
        }
        .card-group:hover .card-glow-ring { opacity: 0.7; }

        /* Light beam container */
        .card-beam-wrap {
            position: absolute;
            inset: -1px;
            border-radius: 1rem;
            overflow: hidden;
            pointer-events: none;
        }

        /* Individual light beams */
        .beam { position: absolute; background: linear-gradient(to right, transparent, rgba(255,255,255,0.85), transparent); }
        .beam-top {
            top: 0; left: 0; height: 2px; width: 50%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.85), transparent);
            animation: beamTop 2.5s ease-in-out infinite;
            animation-delay: 0s;
            filter: blur(1px);
        }
        .beam-right {
            top: 0; right: 0; width: 2px; height: 50%;
            background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.85), transparent);
            animation: beamRight 2.5s ease-in-out infinite;
            animation-delay: 0.6s;
            filter: blur(1px);
        }
        .beam-bottom {
            bottom: 0; right: 0; height: 2px; width: 50%;
            background: linear-gradient(to left, transparent, rgba(255,255,255,0.85), transparent);
            animation: beamBottom 2.5s ease-in-out infinite;
            animation-delay: 1.2s;
            filter: blur(1px);
        }
        .beam-left {
            bottom: 0; left: 0; width: 2px; height: 50%;
            background: linear-gradient(to top, transparent, rgba(255,255,255,0.85), transparent);
            animation: beamLeft 2.5s ease-in-out infinite;
            animation-delay: 1.8s;
            filter: blur(1px);
        }

        @keyframes beamTop    { 0%{left:-50%;opacity:0.3} 50%{opacity:0.7} 100%{left:100%;opacity:0.3} }
        @keyframes beamRight  { 0%{top:-50%;opacity:0.3} 50%{opacity:0.7} 100%{top:100%;opacity:0.3} }
        @keyframes beamBottom { 0%{right:-50%;opacity:0.3} 50%{opacity:0.7} 100%{right:100%;opacity:0.3} }
        @keyframes beamLeft   { 0%{bottom:-50%;opacity:0.3} 50%{opacity:0.7} 100%{bottom:100%;opacity:0.3} }

        /* Corner glow dots */
        .corner { position: absolute; border-radius: 50%; filter: blur(1px); animation: cornerPulse 2s ease-in-out infinite alternate; }
        .corner-tl { top:0; left:0; width:5px; height:5px; background:rgba(255,255,255,0.4); animation-delay:0s; }
        .corner-tr { top:0; right:0; width:8px; height:8px; background:rgba(255,255,255,0.6); filter:blur(2px); animation-delay:0.5s; }
        .corner-br { bottom:0; right:0; width:8px; height:8px; background:rgba(255,255,255,0.6); filter:blur(2px); animation-delay:1s; }
        .corner-bl { bottom:0; left:0; width:5px; height:5px; background:rgba(255,255,255,0.4); animation-delay:1.5s; }
        @keyframes cornerPulse { from { opacity: 0.2; } to { opacity: 0.4; } }

        /* ================================
           GLASS CARD BODY
        ================================ */
        .card-body {
            position: relative;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);
            overflow: hidden;
        }

        /* Inner grid pattern */
        .card-body::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image:
                linear-gradient(135deg, white 0.5px, transparent 0.5px),
                linear-gradient(45deg, white 0.5px, transparent 0.5px);
            background-size: 30px 30px;
            pointer-events: none;
        }

        /* ================================
           LOGO + HEADER
        ================================ */
        .card-header {
            text-align: center;
            margin-bottom: 1.25rem;
        }
        .logo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.1);
            background: linear-gradient(to bottom, rgba(255,255,255,0.1), transparent);
            margin-bottom: 0.5rem;
            position: relative;
            overflow: hidden;
            animation: badgeEntrance 0.8s cubic-bezier(0.34,1.56,0.64,1) forwards;
            opacity: 0;
            transform: scale(0.5);
        }
        @keyframes badgeEntrance {
            to { opacity:1; transform:scale(1); }
        }
        .logo-badge::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom right, rgba(255,255,255,0.1), transparent);
            opacity: 0.5;
        }
        .logo-badge span {
            font-size: 1rem;
            font-weight: 800;
            background: linear-gradient(to bottom, #fff, rgba(255,255,255,0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(to bottom, #fff, rgba(255,255,255,0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeUp 0.5s 0.2s forwards;
            opacity: 0;
            transform: translateY(10px);
        }
        .card-subtitle {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
            margin-top: 0.2rem;
            animation: fadeIn 0.5s 0.3s forwards;
            opacity: 0;
        }
        @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
        @keyframes fadeIn { to { opacity:1; } }

        /* ================================
           ALERT ERROR
        ================================ */
        .alert-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5;
            padding: 0.65rem 0.85rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ================================
           FORM
        ================================ */
        .form-space { display: flex; flex-direction: column; gap: 0.75rem; }

        .input-wrap {
            position: relative;
            transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1);
        }
        .input-wrap:hover { transform: scale(1.01); }
        .input-wrap:focus-within { transform: scale(1.02); z-index: 10; }

        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.4);
            pointer-events: none;
            transition: color 0.3s;
            display: flex;
        }
        .input-wrap:focus-within .input-icon { color: rgba(255,255,255,1); }

        .form-input {
            width: 100%;
            height: 40px;
            background: rgba(255,255,255,0.05);
            border: 1px solid transparent;
            border-radius: 0.5rem;
            color: #fff;
            font-family: inherit;
            font-size: 0.875rem;
            padding: 0 0.75rem 0 2.5rem;
            outline: none;
            transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        }
        .form-input::placeholder { color: rgba(255,255,255,0.3); }
        .form-input:focus {
            border-color: rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
        }
        /* Highlight underlay on focus */
        .input-highlight {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.05);
            border-radius: 0.5rem;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.2s;
            pointer-events: none;
        }
        .input-wrap:focus-within .input-highlight { opacity: 1; }

        /* Password toggle */
        .pwd-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.4);
            cursor: pointer;
            padding: 2px;
            display: flex;
            transition: color 0.3s;
        }
        .pwd-toggle:hover { color: #fff; }
        .pwd-toggle svg { width: 16px; height: 16px; }

        /* Password field gets extra right padding */
        .form-input.has-toggle { padding-right: 2.5rem; }

        /* ================================
           REMEMBER + FORGOT
        ================================ */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.25rem;
        }
        .remember-left { display: flex; align-items: center; gap: 0.5rem; }

        /* Custom checkbox */
        .custom-check-wrap { position: relative; }
        .custom-check {
            appearance: none;
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 4px;
            background: rgba(255,255,255,0.05);
            cursor: pointer;
            transition: all 0.2s;
        }
        .custom-check:checked { background: #fff; border-color: #fff; }
        .check-icon {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            color: #000;
            pointer-events: none;
        }
        .custom-check:checked ~ .check-icon { display: flex; }

        .remember-label { font-size: 0.75rem; color: rgba(255,255,255,0.6); cursor: pointer; transition: color 0.2s; }
        .remember-label:hover { color: rgba(255,255,255,0.8); }

        .forgot-link { font-size: 0.75rem; color: rgba(255,255,255,0.6); text-decoration: none; transition: color 0.2s; }
        .forgot-link:hover { color: #fff; }

        /* ================================
           SUBMIT BUTTON
        ================================ */
        .btn-submit-wrap {
            position: relative;
            margin-top: 1.25rem;
        }
        .btn-submit-glow {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.1);
            border-radius: 0.5rem;
            filter: blur(12px);
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .btn-submit-wrap:hover .btn-submit-glow { opacity: 0.7; }

        .btn-submit {
            position: relative;
            width: 100%;
            height: 40px;
            background: #fff;
            color: #000;
            border: none;
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            transition: transform 0.15s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.2s;
        }
        .btn-submit:hover { transform: scale(1.02); }
        .btn-submit:active { transform: scale(0.98); }

        /* Shimmer sweep */
        .btn-shimmer {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateX(-100%);
            pointer-events: none;
        }
        .btn-submit:hover .btn-shimmer {
            animation: shimmerSweep 0.6s ease forwards;
        }
        @keyframes shimmerSweep { to { transform: translateX(100%); } }

        .btn-submit svg { width: 14px; height: 14px; transition: transform 0.3s; }
        .btn-submit:hover svg { transform: translateX(3px); }

        /* Loading spinner */
        .btn-spinner {
            display: none;
            width: 16px; height: 16px;
            border: 2px solid rgba(0,0,0,0.3);
            border-top-color: #000;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-submit.loading .btn-text { display: none; }
        .btn-submit.loading .btn-spinner { display: block; }

        /* ================================
           DIVIDER
        ================================ */
        .divider {
            display: flex;
            align-items: center;
            margin: 0.5rem 0 1.25rem;
        }
        .divider-line { flex: 1; border-top: 1px solid rgba(255,255,255,0.05); }
        .divider-text { margin: 0 0.75rem; font-size: 0.75rem; color: rgba(255,255,255,0.4); }

        /* ================================
           FOOTER / BACK LINK
        ================================ */
        .card-footer {
            text-align: center;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
            margin-top: 1rem;
        }
        .card-footer a {
            color: #fff;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            display: inline-block;
            transition: color 0.3s;
        }
        .card-footer a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 1px;
            background: #fff;
            transition: width 0.3s;
        }
        .card-footer a:hover::after { width: 100%; }
        .card-footer a:hover { color: rgba(255,255,255,0.8); }
    </style>
</head>
<body>

    <!-- Background layers -->
    <div class="bg-gradient"></div>
    <div class="bg-noise"></div>
    <div class="bg-glow-top"></div>
    <div class="bg-glow-top-pulse"></div>
    <div class="bg-glow-bottom"></div>
    <div class="bg-spot-1"></div>
    <div class="bg-spot-2"></div>

    <!-- Card -->
    <div class="card-wrapper" id="cardWrapper">
        <div class="card-3d" id="card3d">
            <div class="card-group">

                <!-- Glow ring (hover) -->
                <div class="card-glow-ring"></div>

                <!-- Traveling light beams -->
                <div class="card-beam-wrap">
                    <div class="beam beam-top"></div>
                    <div class="beam beam-right"></div>
                    <div class="beam beam-bottom"></div>
                    <div class="beam beam-left"></div>
                    <div class="corner corner-tl"></div>
                    <div class="corner corner-tr"></div>
                    <div class="corner corner-br"></div>
                    <div class="corner corner-bl"></div>
                </div>

                <!-- Glass card -->
                <div class="card-body">

                    <!-- Header -->
                    <div class="card-header">
                        <div class="logo-badge">
                            <span>D</span>
                        </div>
                        <h1 class="card-title">Welcome Back</h1>
                        <p class="card-subtitle">Sign in to continue to CODEVA TECH</p>
                    </div>

                    <!-- Error alert -->
                    @if($errors->any())
                        <div class="alert-error">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm">
                        @csrf

                        <div class="form-space">

                            <!-- Email -->
                            <div class="input-wrap">
                                <span class="input-icon">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-input"
                                    placeholder="Email address"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                >
                                <div class="input-highlight"></div>
                            </div>

                            <!-- Password -->
                            <div class="input-wrap">
                                <span class="input-icon">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-input has-toggle"
                                    placeholder="Password"
                                    required
                                >
                                <button type="button" class="pwd-toggle" id="pwdToggle" aria-label="Toggle password">
                                    <!-- eye-closed icon -->
                                    <svg id="eyeClosed" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    <!-- eye-open icon -->
                                    <svg id="eyeOpen" style="display:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <div class="input-highlight"></div>
                            </div>
                        </div>

                        <!-- Remember me + back link -->
                        <div class="remember-row" style="margin-top: 0.75rem;">
                            <div class="remember-left">
                                <div class="custom-check-wrap">
                                    <input type="checkbox" name="remember" id="remember" class="custom-check">
                                    <div class="check-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                </div>
                                <label for="remember" class="remember-label">Remember me</label>
                            </div>
                            <a href="{{ route('home') }}" class="forgot-link">← Back to site</a>
                        </div>

                        <!-- Sign In Button -->
                        <div class="btn-submit-wrap">
                            <div class="btn-submit-glow"></div>
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <div class="btn-shimmer"></div>
                                <span class="btn-text" style="display:flex; align-items:center; gap: 0.25rem;">
                                    Sign In
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </span>
                                <div class="btn-spinner"></div>
                            </button>
                        </div>

                        <!-- Divider -->
                        <div class="divider">
                            <div class="divider-line"></div>
                            <span class="divider-text">or</span>
                            <div class="divider-line"></div>
                        </div>
                    </form>

                    <!-- Footer -->
                    <div class="card-footer">
                        Panel Kontrol Admin & Teknisi &nbsp;·&nbsp;
                        <a href="{{ route('home') }}">Kembali ke Website</a>
                    </div>

                </div><!-- /card-body -->
            </div><!-- /card-group -->
        </div><!-- /card-3d -->
    </div><!-- /card-wrapper -->

    <script>
        // ===========================
        // 3D tilt on mouse move
        // ===========================
        const wrapper = document.getElementById('cardWrapper');
        const card3d  = document.getElementById('card3d');

        wrapper.addEventListener('mousemove', (e) => {
            const rect = wrapper.getBoundingClientRect();
            const cx = rect.left + rect.width  / 2;
            const cy = rect.top  + rect.height / 2;
            const dx = (e.clientX - cx) / 300; // range -1 to 1
            const dy = (e.clientY - cy) / 300;
            const rotY =  dx * 10;
            const rotX = -dy * 10;
            card3d.style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg)`;
        });

        wrapper.addEventListener('mouseleave', () => {
            card3d.style.transform = 'rotateX(0deg) rotateY(0deg)';
        });

        // ===========================
        // Password toggle
        // ===========================
        const pwdToggle = document.getElementById('pwdToggle');
        const pwdInput  = document.getElementById('password');
        const eyeOpen   = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        pwdToggle.addEventListener('click', () => {
            const isHidden = pwdInput.type === 'password';
            pwdInput.type = isHidden ? 'text' : 'password';
            eyeOpen.style.display   = isHidden ? 'block' : 'none';
            eyeClosed.style.display = isHidden ? 'none'  : 'block';
        });

        // ===========================
        // Loading state on submit
        // ===========================
        document.getElementById('loginForm').addEventListener('submit', () => {
            document.getElementById('submitBtn').classList.add('loading');
        });
    </script>
</body>
</html>
