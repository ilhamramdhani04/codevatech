@extends('layouts.app')

@section('title', 'CODEVA TECH — Service Laptop & Diagnosa Kerusakan')

@section('content')
<style>
    /* Global Section Layout & Spacing */
    .section {
        padding: 6rem 0;
        position: relative;
    }
    .section-border {
        border-bottom: 1px solid var(--border-color);
    }
    .section-header {
        margin-bottom: 3.5rem;
    }
    .section-header.text-center {
        text-align: center;
    }
    .section-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-main);
        line-height: 1.25;
    }
    .section-subtitle {
        font-size: 1.05rem;
        color: var(--text-muted);
        margin-top: 0.75rem;
        max-width: 620px;
        line-height: 1.6;
    }
    .section-header.text-center .section-subtitle {
        margin-left: auto;
        margin-right: auto;
    }

    /* 1. HERO SECTION (Text Overlaid Inside Full-Width Image) */
    .hero-section {
        position: relative;
        min-height: 620px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
        background-color: var(--bg-body);
    }
    .hero-bg-image-wrap {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
    }
    .hero-bg-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transform: scale(1.03);
        transition: transform 0.4s ease;
    }
    .hero-bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, rgba(6, 9, 19, 0.82) 0%, rgba(6, 9, 19, 0.6) 50%, rgba(6, 9, 19, 0.95) 100%),
                    radial-gradient(circle at 50% 40%, rgba(14, 165, 233, 0.3) 0%, transparent 70%);
        z-index: 2;
    }
    .hero-container-overlay {
        position: relative;
        z-index: 3;
        padding: 6rem 1.5rem;
    }
    .hero-content-wrap {
        max-width: 820px;
        margin: 0 auto;
    }
    /* Hero Entrance Animations */
    @keyframes heroTitleEntrance {
        0% {
            opacity: 0;
            transform: translateY(35px) scale(0.97);
            filter: blur(8px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    @keyframes heroDescEntrance {
        0% {
            opacity: 0;
            transform: translateY(25px);
            filter: blur(4px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }
    }

    @keyframes heroActionsEntrance {
        0% {
            opacity: 0;
            transform: translateY(22px) scale(0.92);
        }
        70% {
            transform: translateY(-2px) scale(1.02);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .hero-title {
        font-size: 3.75rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        line-height: 1.12;
        color: #ffffff;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
        animation: heroTitleEntrance 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.15s forwards;
        opacity: 0;
        will-change: transform, opacity, filter;
    }
    .hero-desc {
        font-size: 1.2rem;
        color: #e2e8f0;
        line-height: 1.7;
        margin-bottom: 2.5rem;
        max-width: 680px;
        margin-left: auto;
        margin-right: auto;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
        animation: heroDescEntrance 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.45s forwards;
        opacity: 0;
        will-change: transform, opacity, filter;
    }
    .hero-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        animation: heroActionsEntrance 0.85s cubic-bezier(0.34, 1.56, 0.64, 1) 0.75s forwards;
        opacity: 0;
        will-change: transform, opacity;
    }
    .btn-hero-secondary {
        background-color: rgba(15, 22, 41, 0.7);
        backdrop-filter: blur(8px);
        border-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }
    .btn-hero-secondary:hover {
        background-color: rgba(15, 22, 41, 0.9);
        border-color: var(--accent);
        color: var(--accent);
    }

    /* 2. DEVICE / PROBLEM CATEGORIES */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    .category-item {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.75rem 1.25rem;
        text-decoration: none;
        color: var(--text-main);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: border-color 0.25s ease, transform 0.25s ease, background-color 0.25s ease;
    }
    .category-item:hover {
        border-color: var(--accent);
        transform: translateY(-4px);
        background-color: var(--bg-surface-alt);
    }
    .category-icon {
        width: 48px;
        height: 48px;
        color: var(--accent);
        margin-bottom: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .category-item h4 {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 0.35rem;

    }
    .category-item p {
        font-size: 0.825rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* 3. SERVICE SECTION (Simple Card Layout Matching User Image) */
    .simple-service-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    .simple-service-card {
        position: relative;
        height: 220px;
        border-radius: 20px;
        padding: 2.25rem 2.25rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-decoration: none;
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }
    .simple-service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
    }

    /* Card Themes */
    .simple-service-card.card-red {
        background-color: #dc2626;
        color: #ffffff;
    }
    .simple-service-card.card-dark {
        background-color: #141a29;
        border: 1px solid #1e293b;
        color: #ffffff;
    }
    .simple-service-card.card-blue {
        background-color: #2563eb;
        color: #ffffff;
    }

    .simple-card-title {
        font-size: 1.85rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.025em;
        max-width: 75%;
        color: #ffffff;
    }

    .simple-card-link {
        font-size: 0.825rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        z-index: 2;
        color: #ffffff;
    }
    .simple-card-link svg {
        width: 16px;
        height: 16px;
        transition: transform 0.2s ease;
    }
    .simple-service-card:hover .simple-card-link svg {
        transform: translateX(4px);
    }

    /* Placeholder Graphic Element at Bottom Right */
    .simple-card-graphic {
        position: absolute;
        bottom: -15px;
        right: -15px;
        width: 160px;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.85;
        pointer-events: none;
        transition: transform 0.3s ease;
    }
    .simple-service-card:hover .simple-card-graphic {
        transform: scale(1.08) rotate(-3deg);
    }
    .simple-card-graphic svg {
        width: 130px;
        height: 130px;
        color: rgba(255, 255, 255, 0.4);
    }
    .card-dark .simple-card-graphic svg {
        color: rgba(255, 255, 255, 0.2);
    }

    @media (max-width: 900px) {
        .simple-service-grid {
            grid-template-columns: 1fr;
        }
        .simple-service-card {
            height: 190px;
        }
        .simple-card-title {
            font-size: 1.5rem;
        }
    }

    /* 4. WHY DIAGNOLAP (Editorial 2-Column) */
    .why-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 4rem;
        align-items: start;
    }
    .why-editorial h2 {
        font-size: 2.25rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.25rem;
        color: var(--text-main);
    }
    .why-editorial p {
        font-size: 1.05rem;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 2rem;
    }
    .why-points {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }
    .why-point-item {
        display: flex;
        gap: 1.5rem;
        padding-bottom: 1.75rem;
        border-bottom: 1px solid var(--border-color);
    }
    .why-point-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .why-num {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
        flex-shrink: 0;
        width: 36px;
    }
    .why-point-content h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.35rem;
    }
    .why-point-content p {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* 5. DIAGNOSTIC FEATURE */
    .diag-feature-wrap {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 3.5rem 3rem;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 3.5rem;
        align-items: center;
    }
    .diag-feature-content h3 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 1rem;
        line-height: 1.25;
    }
    .diag-feature-content p {
        font-size: 1rem;
        color: var(--text-sub);
        line-height: 1.7;
        margin-bottom: 2rem;
    }
    .diag-flow-steps {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .flow-step-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }
    .flow-step-badge {
        width: 32px;
        height: 32px;
        background-color: rgba(2, 132, 199, 0.15);
        color: var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    .flow-step-text h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
    }
    .flow-step-text p {
        font-size: 0.825rem;
        color: var(--text-muted);
        margin-top: 0.15rem;
    }

    /* 6. SERVICE PROCESS (Horizontal Timeline) */
    .process-timeline {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 1rem;
        position: relative;
        margin-top: 2rem;
    }
    .process-timeline-card {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.5rem 1rem;
        position: relative;
    }
    .process-num {
        font-size: 0.8rem;
        font-weight: 800;
        color: var(--accent);
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }
    .process-timeline-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.35rem;
    }
    .process-timeline-card p {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* 7. SIMPLE CTA SECTION */
    .cta-box {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 4rem 2rem;
        text-align: center;
        max-width: 840px;
        margin: 0 auto;
    }
    .cta-box h2 {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 0.75rem;
    }
    .cta-box p {
        font-size: 1.05rem;
        color: var(--text-muted);
        margin-bottom: 2rem;
    }
    /* Contact & Google Maps Location Section */
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.15fr;
        gap: 2rem;
        align-items: stretch;
    }

    .contact-info-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .contact-info-card h3 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 0.75rem;
    }

    .contact-info-card p.contact-desc {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 1.75rem;
        line-height: 1.6;
    }

    .location-details {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .location-detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .location-icon-badge {
        width: 42px;
        height: 42px;
        background: rgba(2, 132, 199, 0.15);
        color: var(--accent);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(2, 132, 199, 0.25);
    }

    .location-detail-text h5 {
        color: var(--text-main);
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .location-detail-text p {
        color: var(--text-sub);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .map-frame-container {
        position: relative;
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        min-height: 420px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    }

    .map-frame-container iframe {
        width: 100%;
        height: 100%;
        min-height: 420px;
        border: 0;
        filter: grayscale(85%) invert(92%) contrast(85%) hue-rotate(180deg);
        transition: filter 0.4s ease;
    }

    .map-frame-container:hover iframe {
        filter: grayscale(0%) invert(0%) contrast(100%);
    }

    .map-badge-overlay {
        position: absolute;
        bottom: 1.25rem;
        left: 1.25rem;
        right: 1.25rem;
        background: rgba(15, 23, 42, 0.88);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.9rem 1.2rem;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
    }

    .map-badge-text {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        color: var(--text-main);
        font-weight: 700;
        font-size: 0.875rem;
    }

    .map-badge-btn {
        background: var(--primary);
        color: #ffffff;
        padding: 0.45rem 1rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: background-color 0.2s ease;
        white-space: nowrap;
    }
    .map-badge-btn:hover {
        background: var(--primary-hover);
    }

    /* IntersectionObserver Reveal Animation System */
    .reveal-up {
        opacity: 0;
        transform: translateY(45px);
        transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    .reveal-up.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .reveal-left {
        opacity: 0;
        transform: translateX(-40px);
        transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    .reveal-left.is-visible {
        opacity: 1;
        transform: translateX(0);
    }

    .reveal-right {
        opacity: 0;
        transform: translateX(40px);
        transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    .reveal-right.is-visible {
        opacity: 1;
        transform: translateX(0);
    }

    /* Staggered Children Entrance */
    .reveal-stagger > * {
        opacity: 0;
        transform: translateY(35px) scale(0.96);
        transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    .reveal-stagger.is-visible > *:nth-child(1) { transition-delay: 0.05s; opacity: 1; transform: translateY(0) scale(1); }
    .reveal-stagger.is-visible > *:nth-child(2) { transition-delay: 0.18s; opacity: 1; transform: translateY(0) scale(1); }
    .reveal-stagger.is-visible > *:nth-child(3) { transition-delay: 0.31s; opacity: 1; transform: translateY(0) scale(1); }
    .reveal-stagger.is-visible > *:nth-child(4) { transition-delay: 0.44s; opacity: 1; transform: translateY(0) scale(1); }

    /* Responsive */
    @media (max-width: 1024px) {
        .categories-grid { grid-template-columns: repeat(2, 1fr); }
        .service-asymmetric { grid-template-columns: 1fr; }
        .why-grid { grid-template-columns: 1fr; gap: 2.5rem; }
        .diag-feature-wrap { grid-template-columns: 1fr; }
        .process-timeline { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 640px) {
        .hero-title { font-size: 2.35rem; }
        .categories-grid { grid-template-columns: 1fr; }
        .process-timeline { grid-template-columns: 1fr 1fr; }
        .section { padding: 4rem 0; }
    }
</style>

<!-- 1. HERO SECTION -->
<section class="hero-section section-border">
    <!-- Full-Width Background Image & Overlay -->
    <div class="hero-bg-image-wrap" id="heroVisual">
        <img src="{{ asset('images/hero_editorial.png') }}" alt="Visual Service Laptop Professional">
        <div class="hero-bg-overlay"></div>
    </div>

    <!-- Text Content Overlaid Inside Image -->
    <div class="container hero-container-overlay">
        <div class="hero-content-wrap">
            <h1 class="hero-title">Service Laptop & Diagnosa Kerusakan</h1>
            <p class="hero-desc">Periksa masalah hardware dan software laptop sebelum menentukan langkah perbaikan secara akurat dan transparan.</p>
            <div class="hero-actions">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">📊 Ke Dashboard Admin</a>
                @else
                    <a href="{{ route('diagnosis.index') }}" class="btn btn-primary">Mulai Diagnosa</a>
                @endif
                <a href="https://wa.me/6289653436221" target="_blank" class="btn btn-hero-secondary btn">Hubungi Teknisi</a>
            </div>
        </div>
    </div>
</section>



<!-- 3. SERVICE SECTION (21st.dev / Lavi Katiyar Service Card System) -->
<section class="section section-border" id="layanan">
    <div class="container">
        <div class="section-header text-center reveal-up">
            <h2 class="section-title">Layanan Perbaikan Spesialis</h2>
            <p class="section-subtitle">Dikerjakan dengan standar laboratorium perbaikan elektronik presisi.</p>
        </div>

        <div class="simple-service-grid reveal-stagger">
            <!-- Card 1: Red -->
            <a href="https://wa.me/6289653436221?text=Halo%20CODEVA%20TECH,%20saya%20ingin%20konsultasi%20mengenai%20Perbaikan%20Motherboard%20%26%20Short" target="_blank" class="simple-service-card card-red">
                <h3 class="simple-card-title">Perbaikan Motherboard & Short</h3>
                <div class="simple-card-link">
                    <span>LEARN MORE</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
                <div class="simple-card-graphic">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                </div>
            </a>

            <!-- Card 2: Dark -->
            <a href="https://wa.me/6289653436221?text=Halo%20CODEVA%20TECH,%20saya%20ingin%20konsultasi%20mengenai%20Perbaikan%20Layar%20LCD%20%26%20Panel" target="_blank" class="simple-service-card card-dark">
                <h3 class="simple-card-title">Perbaikan Layar LCD & Panel</h3>
                <div class="simple-card-link">
                    <span>LEARN MORE</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
                <div class="simple-card-graphic">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </a>

            <!-- Card 3: Dark -->
            <a href="https://wa.me/6289653436221?text=Halo%20CODEVA%20TECH,%20saya%20ingin%20konsultasi%20mengenai%20Baterai%20Original%20%26%20Power%20Charger" target="_blank" class="simple-service-card card-dark">
                <h3 class="simple-card-title">Baterai Original & Power Charger</h3>
                <div class="simple-card-link">
                    <span>LEARN MORE</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
                <div class="simple-card-graphic">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </a>

            <!-- Card 4: Blue -->
            <a href="https://wa.me/6289653436221?text=Halo%20CODEVA%20TECH,%20saya%20ingin%20konsultasi%20mengenai%20Cleaning%20%26%20Thermal%20Maintenance" target="_blank" class="simple-service-card card-blue">
                <h3 class="simple-card-title">Cleaning & Thermal Maintenance</h3>
                <div class="simple-card-link">
                    <span>LEARN MORE</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
                <div class="simple-card-graphic">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- 4. WHY CODEVA TECH -->
<section class="section section-border">
    <div class="container">
        <div class="why-grid">
            <div class="why-editorial reveal-left">
                <h2>Laptop Bermasalah? Kami yang Datang.</h2>
                <p>Tidak perlu bongkar perangkat, cari tempat service, atau membawa laptop yang berat. CODEVA TECH menghadirkan layanan teknisi langsung ke lokasi Anda, dengan diagnosis awal yang membantu menentukan masalah sebelum perbaikan dilakukan.</p>
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Ke Dashboard Admin</a>
                @else
                    <a href="{{ route('diagnosis.index') }}" class="btn btn-secondary">Coba Diagnosa Online</a>
                @endif
            </div>

            <div class="why-points reveal-stagger">
                <div class="why-point-item">
                    <div class="why-num">01</div>
                    <div class="why-point-content">
                        <h4>Datang ke Lokasi Anda</h4>
                        <p>Teknisi datang langsung ke rumah atau lokasi yang Anda tentukan.</p>
                    </div>
                </div>

                <div class="why-point-item">
                    <div class="why-num">02</div>
                    <div class="why-point-content">
                        <h4>Cek Sebelum Diperbaiki</h4>
                        <p>Kami periksa gejala dan kondisi perangkat untuk mengetahui kemungkinan sumber masalah.</p>
                    </div>
                </div>

                <div class="why-point-item">
                    <div class="why-num">03</div>
                    <div class="why-point-content">
                        <h4>Penjelasan yang Jelas</h4>
                        <p>Anda mendapatkan penjelasan mengenai kondisi perangkat dan tindakan yang diperlukan sebelum perbaikan.</p>
                    </div>
                </div>

                <div class="why-point-item">
                    <div class="why-num">04</div>
                    <div class="why-point-content">
                        <h4>Hardware & Software</h4>
                        <p>Menangani berbagai masalah laptop dan komputer, mulai dari kendala software hingga kerusakan hardware.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. DIAGNOSTIC FEATURE -->
<section class="section section-border" id="diagnosa">
    <div class="container">
        <div class="diag-feature-wrap reveal-up">
            <div class="diag-feature-content reveal-left">
                <h3>Diagnosa Laptop Sebelum Service</h3>
                <p>Fitur penelusuran mandiri membantu Anda mengetahui estimasi kerusakan berdasarkan indikasi fisik atau sistem sebelum membawa laptop ke lokasi perbaikan.</p>
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Ke Dashboard Admin</a>
                @else
                    <a href="{{ route('diagnosis.index') }}" class="btn btn-primary">Mulai Diagnosa Mandiri</a>
                @endif
            </div>

            <div class="diag-flow-steps reveal-stagger">
                <div class="flow-step-card">
                    <div class="flow-step-badge">1</div>
                    <div class="flow-step-text">
                        <h5>Pilih Brand & Gejala</h5>
                        <p>Tandai indikasi yang paling mendekati kendala laptop Anda.</p>
                    </div>
                </div>

                <div class="flow-step-card">
                    <div class="flow-step-badge">2</div>
                    <div class="flow-step-text">
                        <h5>Analisis Terarah</h5>
                        <p>Sistem memetakan kombinasi fakta gejala dengan basis aturan.</p>
                    </div>
                </div>

                <div class="flow-step-card">
                    <div class="flow-step-badge">3</div>
                    <div class="flow-step-text">
                        <h5>Hasil & Solusi Perbaikan</h5>
                        <p>Dapatkan laporan indikasi kerusakan beserta estimasi solusinya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- 7. CONTACT & LOCATION SECTION (Google Maps Integration) -->
<section class="section" id="kontak">
    <div class="container">
        <div class="section-header text-center reveal-up" style="margin-bottom: 2.5rem;">
            <h2 class="section-title">Lokasi Workshop & Kontak Service</h2>
            <p class="section-subtitle">Kunjungi laboratorium service CODEVA TECH atau hubungi teknisi kami untuk konsultasi langsung.</p>
        </div>

        <div class="contact-grid">
            <!-- Left Card: Workshop Information & Quick Contact -->
            <div class="contact-info-card reveal-left">
                <div>
                    <h3>CODEVA TECH</h3>
                    <p class="contact-desc" style="color: var(--accent); font-weight: 700; margin-bottom: 1.25rem;">Laptop & Computer Service Center</p>

                    <div class="location-details">
                        <div class="location-detail-item">
                            <div class="location-icon-badge">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="location-detail-text">
                                <h5>Alamat Workshop</h5>
                                <p>Jl. Serdang Baru III No. 362, RT.14/RW.5, Serdang, Kemayoran, Jakarta Pusat, 10650</p>
                            </div>
                        </div>

                        <div class="location-detail-item">
                            <div class="location-icon-badge">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="location-detail-text">
                                <h5>Jam Operasional</h5>
                                <p>Senin – Sabtu: 08:00 – 20:00 WIB<br><span style="color: var(--accent); font-size: 0.8rem;">(Hari Minggu / Libur Nasional Tetap Buka via WhatsApp)</span></p>
                            </div>
                        </div>

                        <div class="location-detail-item">
                            <div class="location-icon-badge">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM3 13a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z"/></svg>
                            </div>
                            <div class="location-detail-text">
                                <h5>Layanan Pelanggan</h5>
                                <p>Telepon / WA: +62 89653436221<br>Email: support@codevatech.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary" style="flex: 1;">📊 Ke Dashboard Admin</a>
                    @else
                        <a href="{{ route('diagnosis.index') }}" class="btn btn-primary" style="flex: 1;">🔍 Mulai Diagnosa</a>
                    @endif
                    <a href="https://wa.me/6289653436221" target="_blank" class="btn btn-secondary" style="flex: 1;">💬 Chat WhatsApp</a>
                </div>
            </div>

            <!-- Right Card: Dark Themed Google Maps Placeholder Frame -->
            <div class="map-frame-container reveal-right">
                <iframe 
                    src="https://maps.google.com/maps?q=Jl.+Serdang+Baru+III+No.+362,+Serdang,+Kemayoran,+Jakarta+Pusat&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Google Maps Lokasi CODEVA TECH Service Center">
                </iframe>

                <div class="map-badge-overlay">
                    <div class="map-badge-text">
                        <span>📍</span>
                        <span>CODEVA TECH — Kemayoran, Jakarta Pusat</span>
                    </div>
                    <a href="https://maps.google.com/?q=Jl.+Serdang+Baru+III+No.+362,+Serdang,+Kemayoran,+Jakarta+Pusat" target="_blank" class="map-badge-btn">Buka Maps ↗</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- High-Performance IntersectionObserver Entrance Animation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Native High-Performance IntersectionObserver for Per-Section Scroll Animations
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -10% 0px',
            threshold: 0.12
        };

        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                } else {
                    entry.target.classList.remove('is-visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right, .reveal-stagger').forEach(el => {
            scrollObserver.observe(el);
        });

        // Parallax hero effect
        const heroVisual = document.getElementById('heroVisual');
        if (heroVisual) {
            const heroImg = heroVisual.querySelector('img');
            document.addEventListener('mousemove', (e) => {
                const { clientX, clientY } = e;
                const { innerWidth, innerHeight } = window;
                const x = (clientX / innerWidth - 0.5) * 12;
                const y = (clientY / innerHeight - 0.5) * 12;
                if (heroImg) {
                    heroImg.style.transform = `scale(1.05) translate(${x}px, ${y}px)`;
                }
            });
        }
    });
</script>
@endsection
