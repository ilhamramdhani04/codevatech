<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', (auth()->check() && auth()->user()->isTeknisi() ? 'Panel Teknisi' : 'Admin Panel') . ' — CODEVA TECH')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        (function() {
            var saved = localStorage.getItem('diagnolap_theme');
            var theme = saved ? saved : (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <style>
        :root, [data-theme="dark"] {
            --bg-dark: #090d16;
            --bg-card: #131b2e;
            --bg-hover: #1e293b;
            --primary: #38bdf8;
            --primary-hover: #0284c7;
            --accent: #818cf8;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: #1e293b;
            --danger: #f43f5e;
            --success: #10b981;
            --warning: #f59e0b;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 0px;
            --transition-speed: 0.28s;
            --topbar-bg: rgba(9, 13, 22, 0.55);
            --th-bg: rgba(15, 23, 42, 0.5);
            --input-bg: #090d16;
            --table-hover: rgba(255, 255, 255, 0.02);
            --btn-primary-text: #0f172a;
        }

        [data-theme="light"] {
            --bg-dark: #f1f5f9;
            --bg-card: #ffffff;
            --bg-hover: #e2e8f0;
            --primary: #0284c7;
            --primary-hover: #0369a1;
            --accent: #4f46e5;
            --text-main: #0f172a;
            --text-muted: #475569;
            --border: #cbd5e1;
            --danger: #e11d48;
            --success: #059669;
            --warning: #d97706;
            --topbar-bg: rgba(255, 255, 255, 0.85);
            --th-bg: #f8fafc;
            --input-bg: #ffffff;
            --table-hover: rgba(0, 0, 0, 0.025);
            --btn-primary-text: #ffffff;
        }

        /* Light Mode Specific Overrides */
        [data-theme="light"] .topbar {
            background: rgba(255, 255, 255, 0.85);
            border-bottom-color: rgba(2, 132, 199, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        [data-theme="light"] th {
            background-color: var(--th-bg);
            color: var(--text-muted);
        }

        [data-theme="light"] tr:hover {
            background-color: var(--table-hover);
        }

        [data-theme="light"] .badge-software {
            background-color: rgba(79, 70, 229, 0.12);
            color: #4f46e5;
            border-color: rgba(79, 70, 229, 0.3);
        }

        [data-theme="light"] .badge-hardware {
            background-color: rgba(2, 132, 199, 0.12);
            color: #0284c7;
            border-color: rgba(2, 132, 199, 0.3);
        }

        [data-theme="light"] .gejala-code {
            background-color: rgba(2, 132, 199, 0.1);
            color: #0284c7;
            border-color: rgba(2, 132, 199, 0.25);
        }

        [data-theme="light"] .rule-box {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
        }

        [data-theme="light"] div[style*="background: rgba(15,23,42"],
        [data-theme="light"] div[style*="background: rgba(15, 23, 42"],
        [data-theme="light"] div[style*="background: rgba(15, 22, 41"],
        [data-theme="light"] div[style*="background: rgba(30, 41, 59"],
        [data-theme="light"] li[style*="background: rgba(15,23,42"] {
            background: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        [data-theme="light"] .swal2-popup {
            background: #ffffff !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }
        [data-theme="light"] .swal2-title,
        [data-theme="light"] .swal2-html-container {
            color: #0f172a !important;
        }

        .theme-toggle-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-main);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .theme-toggle-btn:hover {
            background-color: var(--bg-hover);
            border-color: var(--primary);
            color: var(--primary);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* ============================
           TOPBAR — Glassmorphism
        ============================ */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 52px;
            background: rgba(9, 13, 22, 0.55);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid rgba(56, 189, 248, 0.12);
            box-shadow:
                0 1px 0 rgba(56, 189, 248, 0.06),
                0 4px 24px rgba(0, 0, 0, 0.35);
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0 1.25rem;
            z-index: 400;
        }

        /* ============================
           SIDEBAR TOGGLE BUTTON
        ============================ */
        .sidebar-toggle {
            width: 36px;
            height: 36px;
            border-radius: 0.5rem;
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-main);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .sidebar-toggle:hover {
            background-color: var(--bg-hover);
            border-color: var(--primary);
            color: var(--primary);
        }
        .sidebar-toggle svg {
            width: 18px;
            height: 18px;
        }

        .topbar-brand {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            white-space: nowrap;
        }
        .topbar-brand span { color: var(--primary); }

        /* ============================
           SIDEBAR
        ============================ */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 1.25rem 1rem 1rem;
            position: fixed;
            top: 52px; /* below topbar */
            bottom: 0;
            left: 0;
            overflow: hidden; /* Menu list scrolls inside .sidebar-menu-scroll */
            z-index: 200;
            transform: translateX(0);
            transition: transform var(--transition-speed) ease;
        }

        .sidebar-menu-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            margin-right: -0.35rem;
            padding-right: 0.35rem;
        }
        .sidebar-menu-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-menu-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 4px;
        }
        .sidebar-menu-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(56, 189, 248, 0.4);
        }

        .sidebar.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-width)));
        }

        .sidebar .brand {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            padding: 0 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .sidebar .brand span {
            color: var(--primary);
        }

        .sidebar .brand .brand-text {
            transition: opacity var(--transition-speed) ease;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 0.75rem;
        }

        .nav-section-label {
            padding: 0.5rem 0.75rem 0.25rem;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.08em;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity var(--transition-speed) ease;
        }

        .nav-section-label.border-top {
            border-top: 1px solid var(--border);
            margin-top: 0.5rem;
            padding-top: 1rem;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item a:hover, .nav-item a.active {
            background-color: var(--bg-hover);
            color: var(--primary);
        }

        .nav-item a .nav-icon {
            flex-shrink: 0;
            font-size: 1rem;
            width: 1.25rem;
            text-align: center;
        }

        .nav-item a .nav-label {
            transition: opacity var(--transition-speed) ease;
        }

        .user-info {
            margin-top: auto;
            padding-top: 0.85rem;
            padding-bottom: 0;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
            flex-shrink: 0;
            background-color: var(--bg-card);
            z-index: 10;
            white-space: nowrap;
        }

        .user-name {
            font-size: 0.85rem;
            color: var(--text-muted);
            transition: opacity var(--transition-speed) ease;
        }

        .btn-logout {
            background: rgba(244, 63, 94, 0.15);
            color: var(--danger);
            border: 1px solid rgba(244, 63, 94, 0.3);
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 700;
            width: 100%;
            text-align: center;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-logout:hover {
            background: var(--danger);
            color: white;
        }

        /* ============================
           MOBILE OVERLAY
        ============================ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 150;
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }
        .sidebar-overlay.active {
            opacity: 1;
        }

        /* ============================
           MAIN LAYOUT WRAPPER
        ============================ */
        .layout-body {
            display: flex;
            flex: 1;
            margin-top: 52px; /* push below topbar */
            min-height: calc(100vh - 52px);
        }

        /* ============================
           MAIN CONTENT
        ============================ */
        .content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 2.5rem;
            transition: margin-left var(--transition-speed) ease;
            min-width: 0;
        }

        body.sidebar-collapsed .content {
            margin-left: 0;
        }

        .header-title {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* ============================
           UI ELEMENTS
        ============================ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #0f172a;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: var(--bg-hover);
            color: var(--text-main);
            border: 1px solid var(--border);
        }

        .btn-danger {
            background-color: rgba(244, 63, 94, 0.2);
            color: var(--danger);
            border: 1px solid rgba(244, 63, 94, 0.4);
        }

        .btn-danger:hover {
            background-color: var(--danger);
            color: white;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-danger {
            background-color: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }

        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border);
        }

        th {
            background-color: rgba(15, 23, 42, 0.5);
            color: var(--text-muted);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.65rem 0.9rem;
            background-color: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            color: var(--text-main);
            font-family: inherit;
            font-size: 0.95rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        .badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-hardware {
            background-color: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        .badge-software {
            background-color: rgba(129, 140, 248, 0.2);
            color: #a5b4fc;
        }

        /* Pagination Fix */
        nav[role="navigation"] {
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.85rem;
            width: 100%;
        }

        nav[role="navigation"] > div.flex.justify-between:first-child {
            display: none !important;
        }

        nav[role="navigation"] > div {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100%;
            flex-wrap: wrap;
            gap: 1rem;
        }

        nav[role="navigation"] svg {
            width: 1rem !important;
            height: 1rem !important;
            max-width: 1rem !important;
            max-height: 1rem !important;
            display: inline-block;
            vertical-align: middle;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span[aria-disabled="true"],
        nav[role="navigation"] span[aria-current="page"] {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            padding: 0.35rem 0.7rem !important;
            font-size: 0.85rem !important;
            border-radius: 0.375rem;
            background-color: var(--bg-dark);
            color: var(--text-main);
            text-decoration: none;
            border: 1px solid var(--border);
            margin: 0 0.1rem;
            transition: all 0.2s;
            height: 2.2rem;
            min-width: 2.2rem;
        }

        nav[role="navigation"] a:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        nav[role="navigation"] span[aria-current="page"] > span,
        nav[role="navigation"] span[aria-current="page"] {
            background-color: var(--primary) !important;
            color: #0f172a !important;
            font-weight: 700;
            border-color: var(--primary) !important;
        }

        nav[role="navigation"] p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 0;
        }

        /* ============================
           RESPONSIVE
        ============================ */
        @media (max-width: 768px) {
            .sidebar-overlay {
                display: block;
            }
            .content {
                margin-left: 0 !important;
                padding: 1.5rem 1rem;
            }
            body.sidebar-open .sidebar-overlay {
                opacity: 1;
            }
        }
    </style>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <script src="/js/sweetalert2.all.min.js"></script>
    <style>
        /* SweetAlert2 — dark theme override matching admin panel */
        .swal2-popup {
            background: #131b2e !important;
            border: 1px solid #1e293b !important;
            border-radius: 0.875rem !important;
            color: #f8fafc !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            box-shadow: 0 24px 64px rgba(0,0,0,0.6) !important;
        }
        .swal2-title {
            color: #f8fafc !important;
            font-size: 1.2rem !important;
            font-weight: 700 !important;
        }
        .swal2-html-container {
            color: #94a3b8 !important;
            font-size: 0.9rem !important;
        }
        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
        }
        .swal2-icon.swal2-success {
            border-color: #10b981 !important;
            color: #10b981 !important;
        }
        .swal2-icon.swal2-error {
            border-color: #f43f5e !important;
            color: #f43f5e !important;
        }
        .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #10b981 !important;
        }
        .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(16,185,129,0.3) !important;
        }
        .swal2-confirm {
            background: #f43f5e !important;
            border-radius: 0.5rem !important;
            font-weight: 700 !important;
            padding: 0.55rem 1.4rem !important;
            font-size: 0.875rem !important;
        }
        .swal2-confirm.swal2-styled:focus { box-shadow: none !important; }
        .swal2-cancel {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
            color: #f8fafc !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            padding: 0.55rem 1.4rem !important;
            font-size: 0.875rem !important;
        }
        .swal2-cancel:hover { background: #2d3f55 !important; }
        .swal2-actions { gap: 0.5rem !important; }
        .swal2-timer-progress-bar { background: #38bdf8 !important; }

        /* Success / error toast variant */
        .swal2-toast-custom {
            background: #131b2e !important;
            border: 1px solid #1e293b !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5) !important;
        }
    </style>

    <script>
        function confirmDelete(target, customTitle, customMessage) {
            if (target && typeof target.preventDefault === 'function') {
                target.preventDefault();
                target.stopPropagation();
            }

            let form = null;
            let title = customTitle;
            let message = customMessage;

            if (target && target.nodeType) {
                form = target.closest('form');
                if (!title) title = target.getAttribute('data-title');
                if (!message) message = target.getAttribute('data-confirm');
            } else if (target && target.target) {
                const el = target.target;
                form = el.closest('form') || el;
                if (!title) title = el.getAttribute('data-title');
                if (!message) message = el.getAttribute('data-confirm');
            }

            if (!form && target && target.tagName === 'FORM') {
                form = target;
            }

            if (form && !title) title = form.getAttribute('data-title');
            if (form && !message) message = form.getAttribute('data-confirm');

            if (!form) return false;

            let btnText = (target && typeof target.getAttribute === 'function') ? target.getAttribute('data-btn-text') : null;
            let iconType = (target && typeof target.getAttribute === 'function') ? target.getAttribute('data-icon') : null;
            let btnColor = (target && typeof target.getAttribute === 'function') ? target.getAttribute('data-btn-color') : null;

            if (!btnText && form) btnText = form.getAttribute('data-btn-text');
            if (!iconType && form) iconType = form.getAttribute('data-icon');
            if (!btnColor && form) btnColor = form.getAttribute('data-btn-color');

            // Use SweetAlert2 if available, otherwise fallback to native confirm
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: title || 'Konfirmasi Hapus',
                    text: message || 'Data ini akan dihapus secara permanen.',
                    icon: iconType || 'warning',
                    showCancelButton: true,
                    confirmButtonText: btnText || 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: btnColor || '#f43f5e',
                    cancelButtonColor: '#1e293b',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        HTMLFormElement.prototype.submit.call(form);
                    }
                });
            } else {
                // Fallback to native confirm dialog
                if (confirm((title || 'Konfirmasi Hapus') + '\n\n' + (message || 'Data ini akan dihapus secara permanen.'))) {
                    HTMLFormElement.prototype.submit.call(form);
                }
            }

            return false;
        }
    </script>
</head>
<body id="adminBody">

    <!-- Topbar -->
    <header class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle" title="Toggle sidebar (Ctrl+B)" aria-label="Toggle sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <a href="{{ panel_route('dashboard') }}" class="topbar-brand" style="display: inline-flex; align-items: center; gap: 0.55rem; text-decoration: none;">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJtcObdHYptaWihXP8hATC5Go6LAoTGJtPbq7eeInS8w&s" alt="CODEVA TECH Logo" style="height: 26px; width: 26px; object-fit: contain; border-radius: 5px;">
            <span style="font-weight: 800; font-size: 1rem; color: var(--text-main); letter-spacing: -0.02em;">CODEVA <span style="color: #10b981;">TECH</span></span>
            <span style="font-size: 0.72rem; padding: 0.15rem 0.5rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 700; text-transform: uppercase; margin-left: 0.25rem;">{{ auth()->check() && auth()->user()->isTeknisi() ? 'Teknisi' : 'Admin' }}</span>
        </a>
        <div style="margin-left: auto; display: flex; align-items: center; gap: 0.75rem;">
            <button class="theme-toggle-btn" id="themeToggleBtn" aria-label="Switch Light/Dark Theme" title="Beralih Mode Terang / Gelap">
                <span id="themeToggleIcon">🌙</span>
                <span id="themeToggleLabel" style="font-size: 0.8rem;">Dark</span>
            </button>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Layout Body -->
    <div class="layout-body">

    <aside class="sidebar" id="sidebar">
        <a href="{{ panel_route('dashboard') }}" class="brand" style="display: inline-flex; align-items: center; gap: 0.65rem; padding: 0 0.75rem 1rem; border-bottom: 1px solid var(--border); margin-bottom: 0.75rem; text-decoration: none;">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJtcObdHYptaWihXP8hATC5Go6LAoTGJtPbq7eeInS8w&s" alt="CODEVA TECH Logo" style="height: 30px; width: 30px; object-fit: contain; border-radius: 6px; flex-shrink: 0;">
            <div class="brand-text" style="display: inline-flex; align-items: center;">
                <span style="font-size: 0.78rem; padding: 0.2rem 0.65rem; border-radius: 6px; background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                    {{ auth()->check() && auth()->user()->isTeknisi() ? 'Teknisi' : 'Admin' }}
                </span>
            </div>
        </a>
        <div class="sidebar-menu-scroll">
            <ul class="nav-menu">
                <li class="nav-section-label">Operasional</li>
                <li class="nav-item">
                    <a href="{{ panel_route('dashboard') }}" class="{{ panel_routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">📊</span>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                @if(auth()->check() && auth()->user()->isTeknisi())
                <li class="nav-item">
                    <a href="{{ route('diagnosis.index') }}" target="_blank">
                        <span class="nav-icon">🩺</span>
                        <span class="nav-label">Diagnosa Konter ↗</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ panel_route('riwayat.index') }}" class="{{ panel_routeIs('riwayat.*') ? 'active' : '' }}">
                        <span class="nav-icon">📜</span>
                        <span class="nav-label">Riwayat Diagnosis</span>
                    </a>
                </li>
                @if(auth()->check() && auth()->user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ panel_route('analytics.index') }}" class="{{ panel_routeIs('analytics.*') ? 'active' : '' }}">
                        <span class="nav-icon">📈</span>
                        <span class="nav-label">Analisis & Insight</span>
                    </a>
                </li>
                @endif

                <li class="nav-section-label border-top">
                    Knowledge Base {{ auth()->check() && auth()->user()->isTeknisi() ? '(Read-Only)' : '' }}
                </li>
                <li class="nav-item">
                    <a href="{{ panel_route('kategoris.index') }}" class="{{ panel_routeIs('kategoris.*') ? 'active' : '' }}">
                        <span class="nav-icon">🏷️</span>
                        <span class="nav-label">Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ panel_route('brands.index') }}" class="{{ panel_routeIs('brands.*') ? 'active' : '' }}">
                        <span class="nav-icon">🏢</span>
                        <span class="nav-label">Brand Laptop</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ panel_route('laptop-models.index') }}" class="{{ panel_routeIs('laptop-models.*') ? 'active' : '' }}">
                        <span class="nav-icon">💻</span>
                        <span class="nav-label">Model Laptop</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ panel_route('gejalas.index') }}" class="{{ panel_routeIs('gejalas.*') ? 'active' : '' }}">
                        <span class="nav-icon">🩺</span>
                        <span class="nav-label">Master Gejala</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ panel_route('kerusakans.index') }}" class="{{ panel_routeIs('kerusakans.*') ? 'active' : '' }}">
                        <span class="nav-icon">🛠️</span>
                        <span class="nav-label">Master Kerusakan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ panel_route('rules.index') }}" class="{{ panel_routeIs('rules.*') ? 'active' : '' }}">
                        <span class="nav-icon">⚡</span>
                        <span class="nav-label">Rules Inference</span>
                    </a>
                </li>

                @if(auth()->check() && auth()->user()->isAdmin())
                    <li class="nav-section-label border-top">Pengaturan System</li>
                    <li class="nav-item">
                        <a href="{{ panel_route('users.index') }}" class="{{ panel_routeIs('users.*') ? 'active' : '' }}">
                            <span class="nav-icon">👥</span>
                            <span class="nav-label">Kelola User & Teknisi</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="user-info">
            <div style="display: flex; flex-direction: column; gap: 2px;">
                <span class="user-name" style="font-weight: 700; color: var(--text-main);">👤 {{ auth()->user()->name ?? 'User' }}</span>
                <span style="font-size: 0.75rem; color: var(--accent); text-transform: uppercase; font-weight: 700;">
                    Role: {{ auth()->user()->role ?? 'admin' }}
                </span>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                @php
                    $currentRoleName = auth()->check() && auth()->user()->isAdmin() ? 'Super Admin' : 'Teknisi Lab';
                @endphp
                <button type="button" class="btn-logout" 
                    data-title="Konfirmasi Logout" 
                    data-confirm="Apakah Anda yakin ingin logout dari akun {{ $currentRoleName }} ({{ auth()->user()->name ?? 'User' }})?" 
                    data-btn-text="Ya, Logout" 
                    data-icon="question"
                    onclick="confirmDelete(this)">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="content" id="mainContent">
        {{-- Hidden flash data for SweetAlert --}}
        @if(session('success'))
            <span id="flash-success" data-msg="{{ session('success') }}" style="display:none"></span>
        @endif
        @if(session('error'))
            <span id="flash-error" data-msg="{{ session('error') }}" style="display:none"></span>
        @endif

        @yield('content')
    </main>

    <script>
        (function() {
            const STORAGE_KEY = 'diagnolap_sidebar_state';
            const body = document.getElementById('adminBody');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            const isMobile = () => window.innerWidth <= 768;

            // Restore saved state on desktop
            let isCollapsed = false;
            if (!isMobile()) {
                const saved = localStorage.getItem(STORAGE_KEY);
                if (saved === 'collapsed') {
                    isCollapsed = true;
                    applySidebarState(true, false); // no animation on initial load
                }
            } else {
                // Mobile starts with sidebar hidden
                isCollapsed = true;
                sidebar.classList.add('collapsed');
                body.classList.add('sidebar-collapsed');
            }

            function applySidebarState(collapsed, animate = true) {
                if (!animate) {
                    sidebar.style.transition = 'none';
                    content.style.transition = 'none';
                    overlay.style.transition = 'none';
                }

                if (collapsed) {
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                    body.classList.remove('sidebar-open');
                    overlay.classList.remove('active');
                } else {
                    sidebar.classList.remove('collapsed');
                    body.classList.remove('sidebar-collapsed');
                    if (isMobile()) {
                        body.classList.add('sidebar-open');
                        overlay.classList.add('active');
                    }
                }

                if (!animate) {
                    // Re-enable transitions after a brief delay
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            sidebar.style.transition = '';
                            content.style.transition = '';
                            overlay.style.transition = '';
                        });
                    });
                }
            }

            function toggleSidebar() {
                isCollapsed = !isCollapsed;
                applySidebarState(isCollapsed);
                if (!isMobile()) {
                    localStorage.setItem(STORAGE_KEY, isCollapsed ? 'collapsed' : 'open');
                }
            }

            toggleBtn.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking overlay (mobile)
            overlay.addEventListener('click', () => {
                if (!isMobile()) return;
                isCollapsed = true;
                applySidebarState(true);
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    if (!isMobile()) {
                        // Restore saved state for desktop
                        body.classList.remove('sidebar-open');
                        overlay.classList.remove('active');
                        const saved = localStorage.getItem(STORAGE_KEY);
                        isCollapsed = saved === 'collapsed';
                        applySidebarState(isCollapsed, false);
                    } else {
                        // Mobile: collapse by default
                        isCollapsed = true;
                        applySidebarState(true, false);
                    }
                }, 150);
            });

            // Keyboard shortcut: Ctrl+B or Cmd+B
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
        })();
    </script>

    </div><!-- end .layout-body -->

    <!-- SweetAlert2 Controller Script -->
    <script>
        (function() {
            if (typeof Swal === 'undefined') return;

            // Flash message popups (Centered dialog)
            const flashSuccess = document.getElementById('flash-success');
            const flashError   = document.getElementById('flash-error');

            if (flashSuccess && flashSuccess.dataset.msg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: flashSuccess.dataset.msg,
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            }

            if (flashError && flashError.dataset.msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: flashError.dataset.msg,
                    confirmButtonText: 'Tutup'
                });
            }

            // Global event delegation for delete/confirm forms (Centered confirmation dialog)
            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (form && form.hasAttribute('data-confirm')) {
                    if (form.getAttribute('data-confirmed') === 'true') {
                        return true;
                    }
                    e.preventDefault();
                    e.stopPropagation();

                    const msg   = form.getAttribute('data-confirm') || 'Data ini akan dihapus secara permanen.';
                    const title = form.getAttribute('data-title') || 'Konfirmasi Hapus';

                    Swal.fire({
                        title: title,
                        text: msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#f43f5e',
                        cancelButtonColor: '#1e293b',
                        reverseButtons: true,
                        focusCancel: true
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            form.setAttribute('data-confirmed', 'true');
                            form.submit();
                        }
                    });
                }
            }, true);
        })();

        // Theme Toggle System JS
        (function() {
            const btn = document.getElementById('themeToggleBtn');
            const icon = document.getElementById('themeToggleIcon');
            const label = document.getElementById('themeToggleLabel');

            function updateUI(theme) {
                if (theme === 'light') {
                    if (icon) icon.textContent = '☀️';
                    if (label) label.textContent = 'Light';
                } else {
                    if (icon) icon.textContent = '🌙';
                    if (label) label.textContent = 'Dark';
                }
            }

            const current = document.documentElement.getAttribute('data-theme') || 'dark';
            updateUI(current);

            if (btn) {
                btn.addEventListener('click', function() {
                    const now = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
                    const next = now === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', next);
                    localStorage.setItem('diagnolap_theme', next);
                    updateUI(next);
                });
            }
        })();
    </script>
</body>
</html>

