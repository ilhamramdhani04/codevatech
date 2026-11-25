@extends('layouts.admin')

@section('title', 'Analisis Kerusakan per Brand — CODEVA TECH')

@section('content')
<style>
    .analytics-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
        scroll-margin-top: 6rem;
    }

    /* Brand Cards Grid (Default Overview View) */
    .brand-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .brand-select-card {
        text-decoration: none;
        color: inherit;
        background-color: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 0.85rem;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .brand-select-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary);
        box-shadow: 0 10px 25px -5px rgba(56, 189, 248, 0.15);
    }

    .brand-select-card.active {
        border-color: var(--primary);
        background: linear-gradient(145deg, rgba(12, 18, 34, 0.9), rgba(15, 23, 42, 0.95));
        box-shadow: 0 0 20px rgba(56, 189, 248, 0.25);
    }

    .brand-card-top {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .brand-logo-img {
        width: 48px;
        height: 48px;
        border-radius: 0.6rem;
        object-fit: contain;
        background: #fff;
        padding: 6px;
    }

    .brand-logo-fallback {
        width: 48px;
        height: 48px;
        border-radius: 0.6rem;
        background: rgba(56, 189, 248, 0.15);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.25rem;
    }

    .brand-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .brand-card-count {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .brand-top-damage {
        background: var(--bg-hover);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 0.65rem 0.85rem;
        margin-top: 0.75rem;
        font-size: 0.825rem;
    }

    .brand-top-damage label {
        display: block;
        color: var(--text-muted);
        font-size: 0.75rem;
        margin-bottom: 0.2rem;
    }

    .brand-top-damage strong {
        color: var(--accent);
    }

    .brand-card-btn {
        margin-top: 1.25rem;
        width: 100%;
        text-align: center;
        padding: 0.5rem;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: 0.5rem;
        background: rgba(56, 189, 248, 0.1);
        color: var(--primary);
        border: 1px solid rgba(56, 189, 248, 0.2);
        transition: all 0.2s;
    }

    .brand-select-card:hover .brand-card-btn {
        background: var(--primary);
        color: #fff;
    }

    /* Light Mode Overrides for Analytics Page */
    [data-theme="light"] .brand-top-damage {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    [data-theme="light"] .brand-top-damage label {
        color: #475569;
    }

    [data-theme="light"] .brand-top-damage strong {
        color: #0284c7;
        font-weight: 800;
    }

    [data-theme="light"] .brand-card-btn {
        background: rgba(2, 132, 199, 0.08);
        color: #0284c7;
        border-color: rgba(2, 132, 199, 0.25);
    }

    [data-theme="light"] .brand-select-card:hover .brand-card-btn {
        background: #0284c7;
        color: #ffffff;
    }

    [data-theme="light"] .brand-select-card.active {
        background: linear-gradient(145deg, #f0f9ff, #e0f2fe);
        border-color: #0284c7;
        box-shadow: 0 0 20px rgba(2, 132, 199, 0.2);
    }

    [data-theme="light"] input[type="date"] {
        color-scheme: light;
    }

    [data-theme="light"] input[type="date"]::-webkit-calendar-picker-indicator {
        filter: none;
    }

    [data-theme="light"] .progress-bar-wrap {
        background: #e2e8f0;
    }

    [data-theme="light"] .pagination-btn {
        background: #ffffff;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    [data-theme="light"] .pagination-btn.active {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    /* Filter Bar */
    .filter-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        flex: 1;
        min-width: 180px;
    }

    .filter-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    /* KPI Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .kpi-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.6rem;
        background: rgba(56, 189, 248, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .kpi-value {
        font-size: 1.4rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .kpi-label {
        font-size: 0.825rem;
        color: var(--text-muted);
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 992px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 1.5rem;
    }

    .chart-title {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .progress-bar-wrap {
        background: rgba(30, 41, 59, 0.6);
        border-radius: 4px;
        height: 8px;
        width: 100px;
        overflow: hidden;
        display: inline-block;
        vertical-align: middle;
        margin-right: 0.5rem;
    }

    .progress-bar-inner {
        height: 100%;
        background: var(--primary);
        border-radius: 4px;
    }

    .pagination-btn {
        width: 36px;
        height: 36px;
        font-size: 0.875rem;
        font-weight: 700;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(15, 23, 42, 0.8);
        color: var(--text-main);
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .pagination-btn:hover:not(:disabled) {
        background: var(--primary);
        color: #ffffff;
        border-color: var(--primary);
    }

    .pagination-btn.active {
        background: #38bdf8;
        color: #0f172a;
        border-color: #38bdf8;
        font-weight: 800;
    }

    .pagination-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    input[type="date"] {
        color-scheme: dark;
        cursor: pointer;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.8) sepia(1) saturate(5) hue-rotate(170deg);
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
    }

    input[type="date"]::-webkit-calendar-picker-indicator:hover {
        background: rgba(56, 189, 248, 0.2);
    }
</style>

<!-- Top Analytics Header -->
<div class="analytics-header">
    <div>
        <h1 id="pageHeadingTitle">🏢 {{ $selectedBrandId ? 'Analisis Detail Kerusakan Brand: ' . $analytics['active_brand_name'] : 'Analisis Kerusakan Berdasarkan Brand Laptop' }}</h1>
        <p style="color: var(--text-muted);" id="pageHeadingSub">{{ $selectedBrandId ? 'Menampilkan analisis spesifik frekuensi kerusakan untuk Brand ' . $analytics['active_brand_name'] . '.' : 'Klik salah satu Brand di bawah untuk melihat statistik detail kerusakan spesifik brand tersebut.' }}</p>
    </div>
    <div style="display: flex; gap: 0.5rem;" id="headerActionGroup">
        <a id="btnBackToOverview" href="{{ panel_route('analytics.index') }}" class="btn btn-secondary" @if(!$selectedBrandId) style="display: none;" @endif>
            &larr; Kembali ke Overview Brand
        </a>
    </div>
</div>

<p id="analyticsStatus" role="status" hidden style="margin-bottom: 1rem; color: var(--text-muted);"></p>

<!-- SECTION 1: OVERVIEW BRAND CARDS GRID (Pilihan Brand Utama) -->
<div id="overviewBrandSection" @if($selectedBrandId) style="display: none;" @endif>
    <div style="margin-bottom: 1rem; font-weight: 700; font-size: 1.1rem; display: flex; justify-content: space-between; align-items: center;">
        <span>Pilih Brand Laptop untuk Analisis Detail:</span>
        <small style="color: var(--text-muted); font-weight: normal;">Total {{ count($analytics['brand_cards']) }} Brand Terdaftar</small>
    </div>

    <div class="brand-cards-grid">
        @foreach($analytics['brand_cards'] as $bc)
            <a href="{{ panel_route('analytics.index', ['brand_id' => $bc['id']]) }}" data-brand-id="{{ $bc['id'] }}" class="brand-select-card {{ $selectedBrandId == $bc['id'] ? 'active' : '' }}">
                <div>
                    <div class="brand-card-top">
                        @if($bc['logo_url'])
                            <div style="width: 48px; height: 48px; border-radius: 0.6rem; background: #ffffff; padding: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); flex-shrink: 0;">
                                <img src="{{ Str::startsWith($bc['logo_url'], ['http://', 'https://']) ? $bc['logo_url'] : asset('storage/' . $bc['logo_url']) }}" alt="{{ $bc['nama_brand'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            </div>
                        @else
                            <div class="brand-logo-fallback">
                                {{ strtoupper(substr($bc['nama_brand'], 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="brand-card-title">{{ $bc['nama_brand'] }}</div>
                            <div class="brand-card-count">{{ $bc['total_diagnoses'] }} Sesi Diagnosa</div>
                        </div>
                    </div>

                    <div class="brand-top-damage">
                        <label>🔥 Kerusakan Paling Dominan:</label>
                        <strong>{{ $bc['top_damage_name'] }}</strong>
                        @if($bc['top_damage_count'] > 0)
                            <span style="color: var(--text-muted); font-size: 0.75rem;">({{ $bc['top_damage_count'] }} kasus)</span>
                        @endif
                    </div>
                </div>

                <span class="brand-card-btn">
                    Lihat Detail Kerusakan {{ $bc['nama_brand'] }} &rarr;
                </span>
            </a>
        @endforeach
    </div>
</div>

<!-- SECTION 2: BRAND DETAIL ANALYTICS (Tampil Saat Brand Terpilih) -->
<div id="brandDetailSection" @if(!$selectedBrandId) style="display: none;" @endif>

    <!-- Filter Bar untuk Model & Periode Tanggal -->
    <div class="filter-card">
        <div class="filter-group">
            <label>🏢 Brand Laptop Aktif</label>
            <select id="filterBrand" class="form-control">
                <option value="">-- Semua Brand (Overview) --</option>
                @foreach($brands as $b)
                    <option value="{{ $b->id }}" {{ $selectedBrandId == $b->id ? 'selected' : '' }}>{{ $b->nama_brand }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>💻 Model Laptop Specific</label>
            <select id="filterModel" class="form-control">
                <option value="">-- Semua Seri/Model --</option>
                @foreach($laptopModels as $m)
                    <option value="{{ $m->id }}" {{ $selectedModelId == $m->id ? 'selected' : '' }}>{{ $m->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>📅 Dari Tanggal</label>
            <input type="date" id="filterStartDate" class="form-control" value="{{ $startDate }}" onclick="this.showPicker()">
        </div>

        <div class="filter-group">
            <label>📅 Sampai Tanggal</label>
            <input type="date" id="filterEndDate" class="form-control" value="{{ $endDate }}" onclick="this.showPicker()">
        </div>

        <div style="display: flex; gap: 0.5rem; align-items: flex-end;">
            <button id="btnApplyFilter" class="btn btn-primary">🔍 Filter</button>
            <button id="btnResetFilter" class="btn btn-secondary">🔄 Reset</button>
        </div>

        <div style="width: 100%; display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 0.5rem; padding-top: 0.75rem; border-top: 1px dashed var(--border);">
            <span style="font-size: 0.8rem; color: var(--text-muted); align-self: center; font-weight: 600;">⚡ Preset Cepat:</span>
            <button type="button" class="btn btn-secondary" style="padding: 0.35rem 0.65rem; font-size: 0.78rem;" onclick="setPresetDate('7days')">7 Hari Terakhir</button>
            <button type="button" class="btn btn-secondary" style="padding: 0.35rem 0.65rem; font-size: 0.78rem;" onclick="setPresetDate('30days')">30 Hari Terakhir</button>
            <button type="button" class="btn btn-secondary" style="padding: 0.35rem 0.65rem; font-size: 0.78rem;" onclick="setPresetDate('thisMonth')">Bulan Ini</button>
            <button type="button" class="btn btn-secondary" style="padding: 0.35rem 0.65rem; font-size: 0.78rem;" onclick="setPresetDate('all')">Semua Periode</button>
        </div>
    </div>

    <!-- KPI Summaries -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon">📊</div>
            <div>
                <div class="kpi-value" id="kpiTotalCases">{{ $analytics['total_cases'] }}</div>
                <div class="kpi-label">Kasus Kerusakan Terdeteksi</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">🏢</div>
            <div>
                <div class="kpi-value" id="kpiActiveBrand" style="font-size: 1.2rem; color: var(--accent);">{{ $analytics['active_brand_name'] }}</div>
                <div class="kpi-label" id="kpiActiveModel">{{ $analytics['active_model_name'] }}</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">🩺</div>
            <div>
                <div class="kpi-value" id="kpiTotalHistories">{{ $analytics['total_histories'] }}</div>
                <div class="kpi-label">Total Sesi Diagnosa</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">🛠️</div>
            <div>
                <div class="kpi-value" id="kpiTopDamageCode">{{ $analytics['damage_breakdown']->first()->kode_kerusakan ?? '-' }}</div>
                <div class="kpi-label" id="kpiTopDamageName">{{ $analytics['damage_breakdown']->first()->nama_kerusakan ?? 'Belum ada data' }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Bar Chart: Kerusakan Breakdowns -->
        <div class="chart-card">
            <div class="chart-title">
                <span id="chartMainTitle">📊 Grafik Top Kerusakan Brand</span>
                <small style="color: var(--text-muted); font-weight: normal; font-size: 0.8rem;" id="chartSubtitle">Brand: {{ $analytics['active_brand_name'] }}</small>
            </div>
            <div style="position: relative; height: 380px;">
                <p data-chart-unavailable hidden style="padding: 1rem; color: var(--text-muted);">Grafik belum dapat dimuat. Data kerusakan tetap tersedia pada tabel di bawah.</p>
                <canvas id="damageBarChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart: Hardware vs Software -->
        <div class="chart-card">
            <div class="chart-title">
                <span>🏷️ Kategori (Hardware vs Software)</span>
            </div>
            <div style="position: relative; height: 320px; display: flex; align-items: center; justify-content: center;">
                <p data-chart-unavailable hidden style="padding: 1rem; color: var(--text-muted);">Grafik belum dapat dimuat. Data kerusakan tetap tersedia pada tabel di bawah.</p>
                <canvas id="kategoriDonutChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Data Table -->
    <div class="card" style="margin-bottom: 2.5rem;">
        <div class="chart-title" style="margin-bottom: 1rem;">
            <span id="tableTitleText">📋 Detail Breakdown Kerusakan Brand</span>
            <small style="color: var(--text-muted); font-size: 0.85rem;" id="tableSubCount">Total {{ count($analytics['damage_breakdown']) }} Jenis Kerusakan Terdaftar</small>
        </div>

        <div style="overflow-x: auto;">
            <table class="table" id="damageTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Kerusakan</th>
                        <th>Kategori</th>
                        <th>Jumlah Kasus</th>
                        <th>Persentase</th>
                        <th>Visualisasi Rasio</th>
                    </tr>
                </thead>
                <tbody id="damageTableBody">
                    @forelse($analytics['damage_breakdown']->take(10) as $row)
                        <tr>
                            <td><strong>{{ $row->kode_kerusakan }}</strong></td>
                            <td>{{ $row->nama_kerusakan }}</td>
                            <td>
                                <span class="badge {{ strtolower($row->nama_kategori ?? '') === 'software' ? 'badge-software' : 'badge-hardware' }}">
                                    {{ $row->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td><strong>{{ $row->total_count }}</strong> kasus</td>
                            <td><strong>{{ $row->percentage }}%</strong></td>
                            <td>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar-inner" style="width: {{ $row->percentage }}%;"></div>
                                </div>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $row->percentage }}%</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data kerusakan terdeteksi untuk brand terpilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Control Bar (Exact Reuse Code from Laravel Paginator) -->
        <div id="tablePaginationWrap" style="margin-top: 1.5rem;">
            {{ $analytics['damage_breakdown']->links() }}
        </div>
    </div>

</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let selectBrand = null;
    let setPresetDate = null;

    document.addEventListener('DOMContentLoaded', function () {
        let barChartInstance = null;
        let donutChartInstance = null;

        setPresetDate = function (type) {
            const today = new Date();
            const formatDate = (d) => {
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            let startDateStr = '';
            let endDateStr = formatDate(today);

            if (type === '7days') {
                const d = new Date();
                d.setDate(d.getDate() - 7);
                startDateStr = formatDate(d);
            } else if (type === '30days') {
                const d = new Date();
                d.setDate(d.getDate() - 30);
                startDateStr = formatDate(d);
            } else if (type === 'thisMonth') {
                const d = new Date(today.getFullYear(), today.getMonth(), 1);
                startDateStr = formatDate(d);
            } else if (type === 'all') {
                startDateStr = '';
                endDateStr = '';
            }

            document.getElementById('filterStartDate').value = startDateStr;
            document.getElementById('filterEndDate').value = endDateStr;
            document.getElementById('btnApplyFilter').click();
        };

        const initialAnalytics = @json($analytics);
        const brandSelect = document.getElementById('filterBrand');
        const modelSelect = document.getElementById('filterModel');
        const analyticsStatus = document.getElementById('analyticsStatus');
        let latestRequest = 0;

        async function loadAnalytics({ page = 1, updateModels = false, scrollToDetails = false } = {}) {
            const requestId = ++latestRequest;
            const url = new URL(@json(panel_route('analytics.data')));
            url.search = new URLSearchParams({
                brand_id: brandSelect.value,
                laptop_model_id: modelSelect.value,
                start_date: document.getElementById('filterStartDate').value,
                end_date: document.getElementById('filterEndDate').value,
                page
            }).toString();

            analyticsStatus.hidden = false;
            analyticsStatus.setAttribute('role', 'status');
            analyticsStatus.textContent = 'Memuat analisis...';

            try {
                const response = await fetch(url, { headers: { Accept: 'application/json' } });
                if (!response.ok) throw new Error('Analytics request failed');
                const result = await response.json();
                if (!result.success || !result.analytics) throw new Error('Invalid analytics response');
                if (requestId !== latestRequest) return;

                if (updateModels) {
                    modelSelect.replaceChildren(new Option('-- Semua Seri/Model --', ''));
                    (result.laptopModels || []).forEach(model => {
                        modelSelect.add(new Option(model.seri ? `${model.nama_model} (${model.seri})` : model.nama_model, model.id));
                    });
                }

                renderAnalytics(result.analytics);
                analyticsStatus.hidden = true;
                if (scrollToDetails) {
                    document.querySelector('.analytics-header').scrollIntoView({ block: 'start', behavior: 'instant' });
                }
            } catch (error) {
                if (requestId !== latestRequest) return;
                analyticsStatus.setAttribute('role', 'alert');
                analyticsStatus.textContent = 'Analisis gagal dimuat. Silakan klik brand atau tombol Filter untuk mencoba lagi.';
            }
        }

        // Global function to trigger brand selection
        selectBrand = function (brandId) {
            brandSelect.value = brandId;
            modelSelect.replaceChildren(new Option('-- Semua Seri/Model --', ''));
            return loadAnalytics({ updateModels: true, scrollToDetails: true });
        };

        // Initialize Horizontal Bar Chart for full text readability
        function initBarChart(labels, data, fullItems) {
            const ctx = document.getElementById('damageBarChart').getContext('2d');
            if (barChartInstance) barChartInstance.destroy();

            barChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Kasus',
                        data: data,
                        backgroundColor: 'rgba(56, 189, 248, 0.75)',
                        borderColor: '#38bdf8',
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    indexAxis: 'y', // Horizontal bars for full text labels
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#38bdf8',
                            bodyColor: '#f8fafc',
                            borderColor: '#1e293b',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                title: function(context) {
                                    const idx = context[0].dataIndex;
                                    const item = fullItems[idx];
                                    return item ? `[${item.kode_kerusakan}] ${item.nama_kerusakan}` : context[0].label;
                                },
                                label: function(context) {
                                    const idx = context.dataIndex;
                                    const item = fullItems[idx];
                                    const pct = item ? item.percentage : 0;
                                    const kat = item && item.nama_kategori ? item.nama_kategori : 'Umum';
                                    return [
                                        `🏷️ Kategori: ${kat}`,
                                        `📊 Jumlah: ${context.raw} Kasus (${pct}% dari total diagnosa)`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#94a3b8', stepSize: 1 }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { 
                                color: '#f8fafc', 
                                font: { size: 11, weight: '600' }
                            }
                        }
                    }
                }
            });
        }

        // Initialize Donut Chart
        function initDonutChart(labels, data) {
            const ctx = document.getElementById('kategoriDonutChart').getContext('2d');
            if (donutChartInstance) donutChartInstance.destroy();

            donutChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#0284c7', '#818cf8', '#f59e0b', '#10b981'],
                        borderWidth: 2,
                        borderColor: '#0c1222'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#f8fafc', font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Helper to update charts & DOM
        function renderAnalytics(data) {
            const isBrandSelected = data.active_brand_id != null && data.active_brand_id != '';
            document.getElementById('overviewBrandSection').style.display = isBrandSelected ? 'none' : '';
            document.getElementById('brandDetailSection').style.display = isBrandSelected ? '' : 'none';

            // Toggle Header & Button
            if (isBrandSelected) {
                document.getElementById('pageHeadingTitle').innerText = `🏢 Analisis Detail Kerusakan Brand: ${data.active_brand_name}`;
                document.getElementById('pageHeadingSub').innerText = `Menampilkan analisis spesifik frekuensi kerusakan untuk Brand ${data.active_brand_name}.`;
                document.getElementById('btnBackToOverview').style.display = 'inline-flex';
            } else {
                document.getElementById('pageHeadingTitle').innerText = '🏢 Analisis Kerusakan Berdasarkan Brand Laptop';
                document.getElementById('pageHeadingSub').innerText = 'Klik salah satu Brand di bawah untuk melihat statistik detail kerusakan spesifik brand tersebut.';
                document.getElementById('btnBackToOverview').style.display = 'none';
            }

            // Highlight active card state
            document.querySelectorAll('.brand-select-card').forEach(card => {
                card.classList.toggle('active', isBrandSelected && card.dataset.brandId === String(data.active_brand_id));
            });

            // KPI Update
            document.getElementById('kpiTotalCases').innerText = data.total_cases;
            document.getElementById('kpiActiveBrand').innerText = data.active_brand_name;
            document.getElementById('kpiActiveModel').innerText = data.active_model_name;
            document.getElementById('kpiTotalHistories').innerText = data.total_histories;
            
            const rawList = data.damage_breakdown_raw || data.damage_breakdown?.data || [];
            const allDamages = Array.isArray(rawList) ? rawList : Object.values(rawList);
            const topDamage = allDamages[0] || null;
            document.getElementById('kpiTopDamageCode').innerText = topDamage ? topDamage.kode_kerusakan : '-';
            document.getElementById('kpiTopDamageName').innerText = topDamage ? topDamage.nama_kerusakan : 'Belum ada data';

            // Subtitle
            document.getElementById('chartMainTitle').innerText = isBrandSelected ? `📊 Top Kerusakan ${data.active_brand_name}` : '📊 Frekuensi Kerusakan System';
            document.getElementById('chartSubtitle').innerText = 'Filter: ' + data.active_brand_name + ' — ' + data.active_model_name;
            document.getElementById('tableTitleText').innerText = isBrandSelected ? `📋 Detail Kerusakan ${data.active_brand_name}` : '📋 Breakdown Kerusakan System';

            // Bar chart data: Top 10 with FULL damage labels (Horizontal bar)
            // Table Subtitle Count
            const totalDamageCount = allDamages.length;
            document.getElementById('tableSubCount').innerText = `Total ${totalDamageCount} Jenis Kerusakan Terdaftar`;

            // Render Table Rows for Active Page
            const tableItems = data.damage_breakdown ? (data.damage_breakdown.data || data.damage_breakdown) : [];
            const tableBody = document.getElementById('damageTableBody');
            tableBody.innerHTML = '';

            const activeRows = Array.isArray(tableItems) ? tableItems : Object.values(tableItems);
            if (activeRows.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data kerusakan terdeteksi untuk filter terpilih.</td>
                    </tr>
                `;
            } else {
                activeRows.forEach(row => {
                    const isSw = (row.nama_kategori || '').toLowerCase() === 'software';
                    const badgeClass = isSw ? 'badge-software' : 'badge-hardware';
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><strong>${row.kode_kerusakan}</strong></td>
                        <td>${row.nama_kerusakan}</td>
                        <td><span class="badge ${badgeClass}">${row.nama_kategori || 'Umum'}</span></td>
                        <td><strong>${row.total_count}</strong> kasus</td>
                        <td><strong>${row.percentage}%</strong></td>
                        <td>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar-inner" style="width: ${row.percentage}%;"></div>
                            </div>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">${row.percentage}%</span>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });
            }

            // Update Native Laravel Pagination HTML (Reused across system)
            document.getElementById('tablePaginationWrap').innerHTML = data.pagination_html || '';

            // A failed chart dependency must never disable brand navigation or filters.
            let chartsAvailable = typeof Chart !== 'undefined';
            if (isBrandSelected && chartsAvailable) {
                try {
                    const top10Damages = allDamages.slice(0, 10);
                    initBarChart(
                        top10Damages.map(item => `[${item.kode_kerusakan}] ${item.nama_kerusakan}`),
                        top10Damages.map(item => item.total_count),
                        top10Damages
                    );
                    initDonutChart(
                        data.kategori_breakdown.map(item => item.kategori_name),
                        data.kategori_breakdown.map(item => item.total_count)
                    );
                } catch (error) {
                    chartsAvailable = false;
                }
            }
            document.querySelectorAll('[data-chart-unavailable]').forEach(message => {
                message.hidden = chartsAvailable;
            });
            document.getElementById('damageBarChart').hidden = !chartsAvailable;
            document.getElementById('kategoriDonutChart').hidden = !chartsAvailable;
        }

        document.querySelectorAll('.brand-select-card').forEach(card => {
            card.addEventListener('click', function (event) {
                if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
                event.preventDefault();
                selectBrand(this.dataset.brandId);
            });
        });
        document.getElementById('btnBackToOverview').addEventListener('click', function (event) {
            if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
            event.preventDefault();
            selectBrand('');
        });

        // Dynamic Brand Change listener -> fetch models
        brandSelect.addEventListener('change', function () {
            selectBrand(this.value);
        });

        // Apply Filter Button
        document.getElementById('btnApplyFilter').addEventListener('click', function () {
            loadAnalytics();
        });

        // Reset Filter Button
        document.getElementById('btnResetFilter').addEventListener('click', function () {
            document.getElementById('filterStartDate').value = '';
            document.getElementById('filterEndDate').value = '';
            selectBrand('');
        });

        // Intercept click on pagination links to prevent page reload & scroll jump to top
        document.getElementById('tablePaginationWrap').addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.href.endsWith('#')) {
                e.preventDefault();

                const currentScrollY = window.scrollY;
                // Extract page parameter from link URL
                const urlObj = new URL(link.href);
                const pageNum = urlObj.searchParams.get('page') || 1;

                loadAnalytics({ page: pageNum }).then(() => {
                    window.scrollTo({ top: currentScrollY, behavior: 'instant' });
                });
            }
        });

        // Register controls before rendering optional charts.
        renderAnalytics(initialAnalytics);
    });
</script>
@endsection
