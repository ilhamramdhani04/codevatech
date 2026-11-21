<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CODEVA TECH — Service Laptop & Diagnosa Kerusakan')</title>
    <meta name="description" content="Pusat service laptop profesional. Periksa masalah hardware dan software laptop sebelum menentukan langkah perbaikan dengan garansi resmi.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Color System - Clean Professional Dark Navy (inspired by Teknisigo) */
            --bg-body: #060913;
            --bg-surface: #0f1629;
            --bg-surface-alt: #162038;
            --bg-card: #0c1222;
            
            --border-color: #1a2540;
            --border-subtle: #243254;

            --primary: #0284c7;
            --primary-hover: #0369a1;
            --accent: #38bdf8;
            
            --text-main: #f8fafc;
            --text-sub: #cbd5e1;
            --text-muted: #64748b;

            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;

            --container-width: 1200px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* Container */
        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Simple Clean Header */
        header {
            background-color: rgba(6, 9, 19, 0.92);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            transition: border-color 0.3s ease;
        }

        .navbar {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 1.15rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            letter-spacing: -0.02em;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background-color: var(--primary);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .brand span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 2.25rem;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-sub);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--accent);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.6rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: background-color 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
            white-space: nowrap;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-main);
            border-color: var(--border-subtle);
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.825rem;
        }

        main {
            flex: 1;
            width: 100%;
        }

        .main-container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }

        /* Mobile Menu */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            cursor: pointer;
            padding: 0.5rem;
        }

        /* Footer */
        footer {
            background-color: #04070e;
            border-top: 1px solid var(--border-color);
            padding: 4rem 1.5rem 2.5rem;
            color: var(--text-muted);
        }

        .footer-grid {
            max-width: var(--container-width);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand h3 {
            color: var(--text-main);
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
        }

        .footer-brand p {
            font-size: 0.875rem;
            line-height: 1.6;
            max-width: 360px;
            margin-bottom: 1.25rem;
            color: var(--text-muted);
        }

        .footer-col h4 {
            color: var(--text-main);
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.25rem;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .footer-col a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .footer-col a:hover {
            color: var(--accent);
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.875rem;
            margin-bottom: 0.65rem;
            color: var(--text-sub);
        }

        .footer-contact-item svg {
            width: 16px;
            height: 16px;
            color: var(--primary);
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .footer-bottom {
            max-width: var(--container-width);
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.825rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        @media (max-width: 900px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--bg-surface);
                border-bottom: 1px solid var(--border-color);
                flex-direction: column;
                padding: 1.5rem;
                gap: 1rem;
            }
            .nav-links.show {
                display: flex;
            }
            .nav-toggle { display: block; }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 600px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <a href="{{ route('home') }}" class="brand" style="display: inline-flex; align-items: center; gap: 0.65rem;">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJtcObdHYptaWihXP8hATC5Go6LAoTGJtPbq7eeInS8w&s" alt="CODEVA TECH Logo" style="height: 32px; width: 32px; object-fit: contain; border-radius: 6px;">
                <span>CODEVA <span>TECH</span></span>
            </a>

            <button type="button" class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-controls="navMenu" aria-expanded="false">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <ul class="nav-links" id="navMenu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('home') }}#layanan">Layanan</a></li>
                <li><a href="{{ route('home') }}#diagnosa">Diagnosa</a></li>
                <li><a href="{{ route('home') }}#kontak">Kontak</a></li>
                @if(auth()->check() && auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">📊 Dashboard Admin</a></li>
                @elseif(auth()->check() && auth()->user()->isTeknisi())
                    <li><a href="{{ route('teknisi.dashboard') }}" class="btn btn-primary btn-sm">🛠️ Dashboard Teknisi</a></li>
                @else
                    <li><a href="{{ route('diagnosis.index') }}" class="btn btn-primary btn-sm">Mulai Diagnosa</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <main>
        @if(!request()->routeIs('home'))
            <div class="main-container">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @yield('content')
            </div>
        @else
            @if(session('error'))
                <div class="main-container" style="padding-bottom: 0;">
                    <div class="alert alert-danger">{{ session('error') }}</div>
                </div>
            @endif
            @if(session('success'))
                <div class="main-container" style="padding-bottom: 0;">
                    <div class="alert alert-success">{{ session('success') }}</div>
                </div>
            @endif

            @yield('content')
        @endif
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.75rem;">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJtcObdHYptaWihXP8hATC5Go6LAoTGJtPbq7eeInS8w&s" alt="CODEVA TECH Logo" style="height: 32px; width: 32px; object-fit: contain; border-radius: 6px;">
                    <h3 style="margin: 0; font-size: 1.4rem; font-weight: 800;">CODEVA <span style="color: var(--accent);">TECH</span></h3>
                </div>
                <p>Pusat perbaikan dan diagnosa laptop profesional. Mengombinasikan pengalaman teknisi lab dan sistem diagnosa terarah untuk solusi presisi.</p>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="{{ route('home') }}#layanan">Hardware & Motherboard</a></li>
                    <li><a href="{{ route('home') }}#layanan">Layar LCD & Flexibel</a></li>
                    <li><a href="{{ route('home') }}#layanan">Baterai & Charger</a></li>
                    <li><a href="{{ route('home') }}#layanan">Upgrade SSD & RAM</a></li>
                    <li><a href="{{ route('home') }}#layanan">Cleaning Thermal Paste</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                    @elseif(auth()->check() && auth()->user()->isTeknisi())
                        <li><a href="{{ route('teknisi.dashboard') }}">Dashboard Teknisi</a></li>
                    @else
                        <li><a href="{{ route('diagnosis.index') }}">Diagnosa Mandiri</a></li>
                    @endif
                    <li><a href="{{ route('home') }}#layanan">Layanan Perbaikan</a></li>
                    <li><a href="{{ route('home') }}#kontak">Lokasi & Kontak</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kontak Service</h4>
                <div class="footer-contact-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Jl. Serdang Baru III No. 362, Kemayoran, Jakarta Pusat 10650</span>
                </div>
                <div class="footer-contact-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM3 13a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z"/></svg>
                    <span>+62 89653436221 (WA Service)</span>
                </div>
                <div class="footer-contact-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Senin - Sabtu: 08:00 - 20:00 WIB</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} CODEVA TECH. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('navToggle');
            const navMenu = document.getElementById('navMenu');
            if (navToggle && navMenu) {
                const mobileNavigation = window.matchMedia('(max-width: 900px)');
                function closeNavigation() {
                    navMenu.classList.remove('show');
                    navToggle.setAttribute('aria-expanded', 'false');
                }
                navToggle.addEventListener('click', function() {
                    const expanded = navMenu.classList.toggle('show');
                    navToggle.setAttribute('aria-expanded', String(expanded));
                });
                navMenu.addEventListener('click', function(event) {
                    if (mobileNavigation.matches && event.target.closest('a')) {
                        closeNavigation();
                    }
                });
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') closeNavigation();
                });
                mobileNavigation.addEventListener('change', function() {
                    if (!mobileNavigation.matches) closeNavigation();
                });
            }
        });
    </script>
</body>
</html>
