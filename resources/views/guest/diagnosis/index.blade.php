@extends('layouts.app')

@section('title', 'Form Diagnosis Digital — DiagnoLap Laptop Service')

@section('content')
<style>
    .diagnosis-header {
        margin-bottom: 2.5rem;
    }

    .diagnosis-header h1 {
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .diagnosis-header p {
        color: var(--text-muted);
        font-size: 1.05rem;
    }

    .step-indicator {
        display: flex;
        gap: 0;
        margin-bottom: 2.5rem;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .step-item {
        flex: 1;
        padding: 1.25rem 1.75rem;
        background-color: var(--bg-surface);
        display: flex;
        align-items: center;
        gap: 1rem;
        border-right: 1px solid var(--border-color);
    }
    .step-item:last-child {
        border-right: none;
    }

    .step-item.active {
        background-color: rgba(2, 132, 199, 0.08);
    }

    .step-number {
        width: 2.4rem;
        height: 2.4rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.95rem;
        background-color: var(--bg-body);
        border: 1px solid var(--border-light);
        color: var(--text-muted);
        flex-shrink: 0;
    }

    .step-item.active .step-number {
        background-color: var(--primary);
        border-color: var(--primary);
        color: #ffffff;
    }

    .step-label {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-main);
    }

    .step-desc {
        font-size: 0.825rem;
        color: var(--text-muted);
    }

    .laptop-section {
        margin-bottom: 2rem;
    }

    .laptop-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }

    .laptop-field label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-sub);
    }

    .laptop-field select,
    .laptop-field input {
        width: 100%;
        padding: 0.85rem 1.1rem;
        background-color: var(--bg-body);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-main);
        font-size: 0.95rem;
        font-family: inherit;
        appearance: auto;
    }

    .laptop-field select:focus,
    .laptop-field input:focus {
        outline: none;
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .laptop-field select option {
        background-color: var(--bg-surface);
        color: var(--text-main);
    }

    .divider-or {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1.25rem 0;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .divider-or::before,
    .divider-or::after {
        content: '';
        flex: 1;
        height: 1px;
        background-color: var(--border-color);
    }

    .search-input {
        width: 100%;
        padding: 0.85rem 1.2rem;
        background-color: var(--bg-body);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-main);
        font-size: 0.975rem;
        font-family: inherit;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .gejala-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1rem;
        margin-bottom: 2.5rem;
    }

    .gejala-item {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        cursor: pointer;
        transition: border-color 0.2s, background-color 0.2s;
    }

    .gejala-item:hover {
        border-color: var(--border-light);
        background-color: var(--bg-surface-hover);
    }

    .gejala-item input[type="checkbox"] {
        margin-top: 0.2rem;
        width: 1.2rem;
        height: 1.2rem;
        accent-color: var(--primary);
        cursor: pointer;
    }

    .gejala-code {
        font-weight: 700;
        color: var(--primary-light);
        font-size: 0.825rem;
        background-color: rgba(2, 132, 199, 0.12);
        padding: 0.15rem 0.5rem;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(2, 132, 199, 0.2);
    }

    .gejala-name {
        font-size: 0.95rem;
        color: var(--text-main);
        line-height: 1.5;
    }

    .form-footer {
        position: sticky;
        bottom: 1.5rem;
        background-color: rgba(17, 24, 39, 0.96);
        backdrop-filter: blur(12px);
        border: 1px solid var(--border-light);
        padding: 1.25rem 2rem;
        border-radius: var(--radius-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        z-index: 50;
    }

    .counter {
        font-weight: 600;
        color: var(--text-muted);
    }

    .counter span {
        color: var(--primary-light);
        font-size: 1.25rem;
        font-weight: 800;
    }

    .laptop-info-display {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }

    .laptop-info-display strong {
        color: var(--primary-light);
    }

    /* Glassmorphism Category Filter Tabs Container */
    .gejala-tabs-wrapper {
        position: relative;
        margin-top: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .gejala-tabs-container {
        flex: 1;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-lg);
        padding: 0.75rem 0.85rem 0.5rem 0.85rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 8px 32px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .gejala-tabs {
        display: flex;
        gap: 0.6rem;
        overflow-x: auto;
        padding-bottom: 0.6rem;
        scroll-behavior: smooth;
        scrollbar-width: thin;
        scrollbar-color: rgba(2, 132, 199, 0.6) rgba(15, 23, 42, 0.4);
    }

    /* Modern Custom Glassmorphism Scrollbar for Webkit */
    .gejala-tabs::-webkit-scrollbar {
        height: 6px;
    }

    .gejala-tabs::-webkit-scrollbar-button {
        display: none;
        width: 0;
        height: 0;
    }

    .gejala-tabs::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.5);
        border-radius: 10px;
    }

    .gejala-tabs::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, #0284c7, #38bdf8);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(56, 189, 248, 0.4);
        transition: background 0.3s ease;
    }

    .gejala-tabs::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(90deg, #38bdf8, #818cf8);
        box-shadow: 0 0 14px rgba(56, 189, 248, 0.8);
    }

    /* Glassmorphism Tab Items */
    .gejala-tab-item {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #cbd5e1;
        padding: 0.55rem 1.15rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }

    .gejala-tab-item:hover {
        background: rgba(51, 65, 85, 0.8);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }

    .gejala-tab-item.active {
        background: linear-gradient(135deg, rgba(2, 132, 199, 0.95), rgba(14, 165, 233, 0.85));
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #ffffff;
        border-color: rgba(56, 189, 248, 0.6);
        box-shadow: 0 4px 20px rgba(2, 132, 199, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .gejala-tab-badge {
        font-size: 0.75rem;
        padding: 0.1rem 0.5rem;
        border-radius: 50px;
        font-weight: 700;
        line-height: 1;
    }

    .gejala-tab-item:not(.active) .gejala-tab-badge {
        background: rgba(148, 163, 184, 0.2);
        color: var(--text-muted);
    }

    .gejala-tab-item.active .gejala-tab-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .gejala-tab-item:not(.active) .gejala-tab-badge.has-count {
        background: var(--accent);
        color: #0f172a;
    }

    .tab-scroll-btn {
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #f8fafc;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        z-index: 10;
        flex-shrink: 0;
    }

    .tab-scroll-btn:hover {
        background: var(--primary);
        color: #ffffff;
        border-color: var(--primary-light);
        box-shadow: 0 0 12px rgba(56, 189, 248, 0.5);
    }
</style>

<div class="diagnosis-header">
    @if(auth()->check())
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.825rem; font-weight: 700; margin-bottom: 0.75rem;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px #10b981;"></span>
            🔑 Mode Diagnosa Teknisi Lab ({{ auth()->user()->role === 'admin' ? 'Super Admin' : 'Teknisi' }}: {{ auth()->user()->name }}) — Akses SOP Full
        </div>
    @else
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(56, 189, 248, 0.1); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.25); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.825rem; font-weight: 600; margin-bottom: 0.75rem;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #38bdf8;"></span>
            👤 Mode Diagnosa Publik (Guest)
        </div>
    @endif
    <h1>Form Diagnosa Digital Laptop</h1>
    <p>Identifikasi merek/model laptop Anda dan centang indikasi masalah yang sedang terjadi.</p>
</div>

<!-- Step Indicator -->
<div class="step-indicator">
    <div class="step-item active">
        <div class="step-number">1</div>
        <div>
            <div class="step-label">Identifikasi Laptop</div>
            <div class="step-desc">Pilih merek & model perangkat</div>
        </div>
    </div>
    <div class="step-item active">
        <div class="step-number">2</div>
        <div>
            <div class="step-label">Input Indikasi Gejala</div>
            <div class="step-desc">Centang masalah yang dialami</div>
        </div>
    </div>
</div>

<form action="{{ route('diagnosis.process') }}" method="POST" id="diagnosisForm">
    @csrf

    <!-- Step 1: Identifikasi Laptop -->
    <div class="card laptop-section">
        <h3 style="margin-bottom: 0.75rem; font-size: 1.2rem; font-weight: 700;">Step 1: Identifikasi Laptop Anda</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Pilih merek dan model laptop. Langkah ini membantu memberikan diagnosa yang lebih presisi (Opsional — Anda dapat melewati jika tidak tahu).</p>

        <div class="laptop-grid">
            <div class="laptop-field">
                <label for="nama_pengguna">Nama Pemilik / Customer (Opsional)</label>
                <input type="text" name="nama_pengguna" id="nama_pengguna" placeholder="{{ auth()->check() ? 'Masukkan nama customer / pemilik laptop...' : 'Masukkan nama Anda...' }}" value="{{ old('nama_pengguna') }}">
            </div>
            <div class="laptop-field">
                <label for="brand_id">Merek Laptop</label>
                <select name="brand_id" id="brand_id">
                    <option value="">— Pilih Merek Laptop —</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->nama_brand }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="laptop-field">
                <label for="laptop_model_id">Model / Seri Laptop</label>
                <select name="laptop_model_id" id="laptop_model_id" disabled>
                    <option value="">— Pilih merek dulu —</option>
                </select>
            </div>
        </div>

        <div class="divider-or">atau ketik manual jika merek/model tidak ada di daftar</div>

        <div class="laptop-field">
            <input type="text" name="laptop_info_manual" id="laptop_info_manual" placeholder="Contoh: Toshiba Satellite C55, HP Pavilion G4, Lenovo IdeaPad Lama..." value="{{ old('laptop_info_manual') }}">
        </div>
    </div>

    <!-- Step 2: Pilih Gejala -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <h3 style="margin-bottom: 0.75rem; font-size: 1.2rem; font-weight: 700;">Step 2: Pilih Gejala yang Dialami</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">
            Pilih kategori di bawah untuk menyaring gejala, atau ketik kata kunci pada pencarian.
        </p>

        <div class="laptop-field">
            <input type="text" id="searchGejala" class="search-input" placeholder="🔍 Cari kata kunci gejala (misal: layar, mati, baterai, touchpad, wifi, bootloop)...">
        </div>

        <!-- Category Filter Tabs (Glassmorphism + Neon Dark Scrollbar) -->
        <div class="gejala-tabs-wrapper">
            <button type="button" class="tab-scroll-btn" id="scrollTabsLeft" title="Geser Kiri">◀</button>
            <div class="gejala-tabs-container">
                <div class="gejala-tabs" id="gejalaTabs">
                    <button type="button" class="gejala-tab-item active" data-category="frequent">
                        🔥 Paling Sering Terjadi <span class="gejala-tab-badge" id="badge-frequent">0</span>
                    </button>
                    <button type="button" class="gejala-tab-item" data-category="all">
                        🌐 Semua Gejala <span class="gejala-tab-badge" id="badge-all">0</span>
                    </button>
                    <button type="button" class="gejala-tab-item" data-category="power">
                        ⚡ Daya & Baterai <span class="gejala-tab-badge" id="badge-power">0</span>
                    </button>
                    <button type="button" class="gejala-tab-item" data-category="display">
                        🖥️ Layar & Tampilan <span class="gejala-tab-badge" id="badge-display">0</span>
                    </button>
                    <button type="button" class="gejala-tab-item" data-category="performance">
                        ⚙️ Performa & Hardware <span class="gejala-tab-badge" id="badge-performance">0</span>
                    </button>
                    <button type="button" class="gejala-tab-item" data-category="input">
                        ⌨️ Input & Perangkat <span class="gejala-tab-badge" id="badge-input">0</span>
                    </button>
                    <button type="button" class="gejala-tab-item" data-category="system">
                        🔒 Sistem, Firmware & AI <span class="gejala-tab-badge" id="badge-system">0</span>
                    </button>
                </div>
            </div>
            <button type="button" class="tab-scroll-btn" id="scrollTabsRight" title="Geser Kanan">▶</button>
        </div>
    </div>

    @php
        $frequentCodes = $frequentCodes ?? ['G01', 'G02', 'G03', 'G09', 'G10', 'G13', 'G15', 'G16', 'G21', 'G30', 'G54', 'G61'];
        $powerCodes = ['G01', 'G02', 'G03', 'G04', 'G15', 'G16', 'G17', 'G18', 'G19', 'G20', 'G56', 'G63', 'G64'];
        $displayCodes = ['G05', 'G06', 'G07', 'G08', 'G57', 'G58'];
        $perfCodes = ['G09', 'G10', 'G11', 'G12', 'G13', 'G14', 'G30', 'G38', 'G39', 'G42', 'G65', 'G66'];
        $inputCodes = ['G21', 'G22', 'G23', 'G24', 'G25', 'G26', 'G27', 'G28', 'G29', 'G43', 'G44', 'G45', 'G46', 'G47', 'G52', 'G53'];
        $systemCodes = ['G31', 'G32', 'G33', 'G34', 'G35', 'G36', 'G37', 'G40', 'G41', 'G48', 'G49', 'G50', 'G51', 'G54', 'G55', 'G59', 'G60', 'G61', 'G62'];
    @endphp

    <div class="gejala-grid" id="gejalaList">
        @foreach($gejalas as $gejala)
            @php
                $cats = ['all'];
                if (in_array($gejala->kode_gejala, $frequentCodes)) $cats[] = 'frequent';
                if (in_array($gejala->kode_gejala, $powerCodes)) $cats[] = 'power';
                if (in_array($gejala->kode_gejala, $displayCodes)) $cats[] = 'display';
                if (in_array($gejala->kode_gejala, $perfCodes)) $cats[] = 'performance';
                if (in_array($gejala->kode_gejala, $inputCodes)) $cats[] = 'input';
                if (in_array($gejala->kode_gejala, $systemCodes)) $cats[] = 'system';
                $catAttr = implode(' ', $cats);
            @endphp
            <label class="gejala-item" data-categories="{{ $catAttr }}" data-text="{{ strtolower($gejala->kode_gejala . ' ' . $gejala->nama_gejala) }}">
                <input type="checkbox" name="gejala_ids[]" value="{{ $gejala->id }}" class="gejala-checkbox" {{ is_array(old('gejala_ids')) && in_array($gejala->id, old('gejala_ids')) ? 'checked' : '' }}>
                <div>
                    <span class="gejala-code">{{ $gejala->kode_gejala }}</span>
                    <span class="gejala-name">{{ $gejala->nama_gejala }}</span>
                </div>
            </label>
        @endforeach
    </div>
    
    <div id="noGejalaNotice" style="display: none; text-align: center; padding: 3rem 1.5rem; background: var(--bg-surface); border: 1px dashed var(--border-color); border-radius: var(--radius-lg); margin-bottom: 2rem; color: var(--text-muted);">
        <p style="font-size: 1.1rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem;">Tidak ditemukan gejala pada kategori ini</p>
        <p style="font-size: 0.9rem;">Coba ketik kata kunci pada kolom pencarian di atas atau pilih tab <strong>"Semua Gejala"</strong>.</p>
    </div>

    <div class="form-footer">
        <div>
            <div class="counter">
                Gejala Terpilih: <span id="selectedCount">0</span>
            </div>
            <div class="laptop-info-display" id="laptopInfoDisplay"></div>
        </div>
        <button type="submit" class="btn btn-primary" style="font-size: 1.05rem; padding: 0.8rem 2.25rem;">
            🔍 Proses Diagnosa Digital
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.gejala-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const searchInput = document.getElementById('searchGejala');
        const gejalaItems = document.querySelectorAll('.gejala-item');
        const brandSelect = document.getElementById('brand_id');
        const modelSelect = document.getElementById('laptop_model_id');
        const manualInput = document.getElementById('laptop_info_manual');
        const laptopInfoDisplay = document.getElementById('laptopInfoDisplay');

        // === Data model per brand (dari server) ===
        const modelsByBrand = @json($modelsByBrand);

        // === Tab & Filter logic ===
        const tabItems = document.querySelectorAll('.gejala-tab-item');
        const gejalaTabs = document.getElementById('gejalaTabs');
        const btnScrollLeft = document.getElementById('scrollTabsLeft');
        const btnScrollRight = document.getElementById('scrollTabsRight');
        const noGejalaNotice = document.getElementById('noGejalaNotice');
        let currentCategory = 'frequent';

        if (btnScrollLeft && btnScrollRight && gejalaTabs) {
            btnScrollLeft.addEventListener('click', () => {
                gejalaTabs.scrollBy({ left: -220, behavior: 'smooth' });
            });
            btnScrollRight.addEventListener('click', () => {
                gejalaTabs.scrollBy({ left: 220, behavior: 'smooth' });
            });
        }

        function filterGejala() {
            const query = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            gejalaItems.forEach(item => {
                const text = item.getAttribute('data-text');
                const categories = item.getAttribute('data-categories').split(' ');

                const matchesTab = categories.includes(currentCategory);
                const matchesSearch = query === '' || text.includes(query);

                if (matchesTab && matchesSearch) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                noGejalaNotice.style.display = 'block';
            } else {
                noGejalaNotice.style.display = 'none';
            }
        }

        tabItems.forEach(tab => {
            tab.addEventListener('click', function() {
                tabItems.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentCategory = this.getAttribute('data-category');
                filterGejala();
            });
        });

        searchInput.addEventListener('input', filterGejala);

        // === Gejala counter & Tab Badges ===
        function updateCountAndBadges() {
            const checkedCheckboxes = document.querySelectorAll('.gejala-checkbox:checked');
            selectedCount.textContent = checkedCheckboxes.length;

            const counts = {
                frequent: 0,
                all: 0,
                power: 0,
                display: 0,
                performance: 0,
                input: 0,
                system: 0
            };

            checkedCheckboxes.forEach(cb => {
                const item = cb.closest('.gejala-item');
                const cats = item.getAttribute('data-categories').split(' ');
                cats.forEach(c => {
                    if (counts[c] !== undefined) counts[c]++;
                });
            });

            Object.keys(counts).forEach(cat => {
                const badge = document.getElementById(`badge-${cat}`);
                if (badge) {
                    badge.textContent = counts[cat];
                    if (counts[cat] > 0) {
                        badge.classList.add('has-count');
                    } else {
                        badge.classList.remove('has-count');
                    }
                }
            });
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateCountAndBadges));

        // Initial execution
        updateCountAndBadges();
        filterGejala();

        // === Brand → Model dropdown ===
        brandSelect.addEventListener('change', function() {
            const brandId = this.value;
            modelSelect.innerHTML = '';

            if (!brandId) {
                modelSelect.innerHTML = '<option value="">— Pilih merek dulu —</option>';
                modelSelect.disabled = true;
                updateLaptopDisplay();
                return;
            }

            const models = modelsByBrand[brandId] || [];
            modelSelect.disabled = false;

            let options = '<option value="">— Pilih Model —</option>';
            models.forEach(m => {
                const display = m.seri ? `${m.nama_model} (${m.seri})` : m.nama_model;
                options += `<option value="${m.id}" data-kategori="${m.kategori_laptop}">${display}</option>`;
            });
            modelSelect.innerHTML = options;

            // Restore old value jika ada
            const oldModelId = '{{ old('laptop_model_id', '') }}';
            if (oldModelId) {
                modelSelect.value = oldModelId;
            }

            updateLaptopDisplay();
        });

        modelSelect.addEventListener('change', updateLaptopDisplay);
        manualInput.addEventListener('input', updateLaptopDisplay);

        // === Laptop info display di footer ===
        function updateLaptopDisplay() {
            const brandText = brandSelect.options[brandSelect.selectedIndex]?.text;
            const modelText = modelSelect.options[modelSelect.selectedIndex]?.text;
            const manual = manualInput.value.trim();

            let display = '';
            if (brandSelect.value && brandText !== '— Pilih Merek Laptop —') {
                display = 'Laptop: <strong>' + brandText + '</strong>';
                if (modelSelect.value && modelText !== '— Pilih Model —') {
                    display += ' — ' + modelText;
                }
            } else if (manual) {
                display = 'Laptop: <strong>' + manual + '</strong>';
            }

            laptopInfoDisplay.innerHTML = display;
        }

        // === Disable manual input jika brand dipilih & sebaliknya ===
        brandSelect.addEventListener('change', function() {
            if (this.value) {
                manualInput.value = '';
                manualInput.disabled = true;
                manualInput.placeholder = 'Anda sudah memilih merek dari dropdown di atas';
            } else {
                manualInput.disabled = false;
                manualInput.placeholder = 'Contoh: Laptop Toshiba Satellite C55, HP Pavilion lama...';
            }
        });

        manualInput.addEventListener('input', function() {
            if (this.value.trim()) {
                brandSelect.value = '';
                modelSelect.innerHTML = '<option value="">— Pilih merek dulu —</option>';
                modelSelect.disabled = true;
            }
        });

        // === Trigger brand change on load (for old() value) ===
        if (brandSelect.value) {
            brandSelect.dispatchEvent(new Event('change'));
        }

        updateLaptopDisplay();
    });
</script>
@endsection
