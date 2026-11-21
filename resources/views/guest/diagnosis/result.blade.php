@extends('layouts.app')

@section('title', 'Laporan Hasil Diagnosa — DiagnoLap Laptop Service')

@section('content')
<style>
    .result-header {
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .result-header h1 {
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .result-meta {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: var(--text-main);
    }

    .gejala-selected-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
    }

    .gejala-pill {
        background-color: var(--bg-body);
        border: 1px solid var(--border-color);
        padding: 0.45rem 0.9rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        color: var(--text-sub);
    }

    .gejala-pill strong {
        color: var(--primary-light);
    }

    .result-card {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-left: 5px solid var(--primary);
        border-radius: var(--radius-lg);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .result-card.software {
        border-left-color: var(--accent);
    }

    .result-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .kerusakan-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.3;
    }

    .kerusakan-code {
        color: var(--primary-light);
        margin-right: 0.5rem;
    }

    .info-block {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .info-block h4 {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 0.85rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-list {
        list-style-position: inside;
        color: var(--text-muted);
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        font-size: 0.95rem;
    }

    .solusi-steps {
        list-style: none;
        counter-reset: solusi-counter;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .solusi-steps li {
        counter-increment: solusi-counter;
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        background-color: var(--bg-body);
        padding: 1rem 1.25rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        font-size: 0.95rem;
        color: var(--text-sub);
    }

    .solusi-steps li::before {
        content: counter(solusi-counter);
        background-color: var(--primary);
        color: #ffffff;
        font-weight: 800;
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.85rem;
    }

    .empty-result {
        text-align: center;
        padding: 3.5rem 2rem;
        background-color: var(--bg-surface);
        border: 1px dashed var(--warning);
        border-radius: var(--radius-lg);
        margin-bottom: 2.5rem;
    }

    .empty-result h3 {
        color: var(--warning);
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .booking-callout {
        background: linear-gradient(135deg, rgba(2, 132, 199, 0.12), rgba(99, 102, 241, 0.08));
        border: 1px solid var(--border-light);
        border-radius: var(--radius-lg);
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    /* Circular Confidence Bar System */
    .confidence-section {
        background-color: var(--bg-body);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.25rem 1.5rem;
        margin-top: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1.75rem;
    }

    .circle-chart-container {
        position: relative;
        width: 90px;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .circle-chart {
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }

    .circle-chart-percentage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.15rem;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .confidence-info {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .confidence-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .confidence-desc {
        font-size: 0.825rem;
        color: var(--text-muted);
    }

    .confidence-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 700;
        width: fit-content;
        margin-top: 0.2rem;
    }
</style>

<div class="result-header">
    <h1>Laporan Hasil Diagnosa Digital</h1>
    <div class="result-meta">
        Waktu Pengujian: {{ $history->tanggal_diagnosis->format('d M Y, H:i') }} WIB
        @if($history->user)
            | Teknisi Penguji: <strong>{{ $history->user->name }}</strong>
        @endif
        @if($history->nama_pengguna)
            | Pemilik / Customer: <strong>{{ $history->nama_pengguna }}</strong>
        @endif
    </div>
    @if($history->laptop_display)
        <div class="result-meta" style="margin-top: 0.4rem;">
            Perangkat Laptop: <strong style="color: var(--primary-light);">{{ $history->laptop_display }}</strong>
        </div>
    @endif
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div class="section-title">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        Indikasi Gejala Terpilih ({{ $history->diagnosisGejala->count() }})
    </div>
    <div class="gejala-selected-list">
        @foreach($history->diagnosisGejala as $dg)
            <div class="gejala-pill">
                <strong>{{ $dg->gejala->kode_gejala }}</strong> — {{ $dg->gejala->nama_gejala }}
            </div>
        @endforeach
    </div>
</div>

<div class="section-title">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
    Hasil Inferensi Kerusakan
</div>

@if($history->diagnosisResults->isEmpty())
    @php
        $userGejalaIds = $history->diagnosisGejala->pluck('gejala_id')->toArray();
        $allRules = \App\Models\Rule::with(['kerusakan.kategori', 'kerusakan.penyebabs', 'kerusakan.solusis', 'ruleGejala'])->get();

        $candidateMap = [];

        foreach ($allRules as $rule) {
            $posGejalas = $rule->ruleGejala->where('is_negated', false)->pluck('gejala_id')->toArray();
            $negGejalas = $rule->ruleGejala->where('is_negated', true)->pluck('gejala_id')->toArray();

            $totalPosRequired = count($posGejalas);
            if ($totalPosRequired === 0 || !$rule->kerusakan) {
                continue;
            }

            // Cek jika ada syarat NOT yang dilanggar pengguna
            $violatesNegated = false;
            foreach ($negGejalas as $negId) {
                if (in_array($negId, $userGejalaIds)) {
                    $violatesNegated = true;
                    break;
                }
            }

            if ($violatesNegated) {
                continue;
            }

            // Hitung berapa gejala positif yang dicentang pengguna
            $matchedPosCount = count(array_intersect($userGejalaIds, $posGejalas));

            if ($matchedPosCount > 0) {
                // Murni persentase realitas: (gejala positif terpilih / total gejala positif rule) * 100
                $p = (int) round(($matchedPosCount / $totalPosRequired) * 100);
                $kerusakanId = $rule->kerusakan_id;

                if (!isset($candidateMap[$kerusakanId]) || $p > $candidateMap[$kerusakanId]['percentage']) {
                    $candidateMap[$kerusakanId] = [
                        'kerusakan'  => $rule->kerusakan,
                        'percentage' => $p,
                    ];
                }
            }
        }

        // Filter candidate with percentage > 0, sort DESC, take Top 3
        $topCandidates = collect($candidateMap)
            ->filter(fn($c) => $c['percentage'] > 0)
            ->sortByDesc('percentage')
            ->take(3);
    @endphp

    <div class="empty-result">
        <h3>Indikasi Gejala Overlap / Diagnosa Parsial</h3>
        <p style="color: var(--text-muted); max-width: 650px; margin: 0.5rem auto 1.5rem; line-height: 1.6;">
            Berdasarkan kombinasi gejala yang Anda pilih, terdapat gejala ganda/overlap.
            Berikut adalah <strong>Top {{ $topCandidates->count() }} Potensi Kerusakan</strong> berdasarkan tingkat kecocokan indikasi:
        </p>

        @forelse($topCandidates as $cand)
            @php
                $candKerusakan = $cand['kerusakan'];
                $percentage = $cand['percentage'];
                $isSoftware = strtolower($candKerusakan->kategori->nama_kategori ?? '') === 'software';

                if ($percentage > 85) {
                    $color = '#10b981'; $statusText = 'Tinggi (Cocok Penuh)';
                } elseif ($percentage > 50) {
                    $color = '#f97316'; $statusText = 'Sedang (Cocok Sebagian)';
                } elseif ($percentage > 30) {
                    $color = '#facc15'; $statusText = 'Rendah (Indikasi Awal)';
                } else {
                    $color = '#ef4444'; $statusText = 'Sangat Rendah';
                }
                $radius = 38;
                $circumference = 2 * M_PI * $radius;
                $dashoffset = $circumference - ($percentage / 100) * $circumference;
            @endphp

            <div class="result-card {{ $isSoftware ? 'software' : '' }}" style="text-align: left; margin-bottom: 1.5rem;">
                <div class="result-top">
                    <div>
                        <div class="kerusakan-name">
                            <span class="kerusakan-code">[{{ $candKerusakan->kode_kerusakan }}]</span>
                            {{ $candKerusakan->nama_kerusakan }}
                        </div>
                    </div>
                    <span class="badge {{ $isSoftware ? 'badge-software' : 'badge-hardware' }}">
                        Kategori: {{ $candKerusakan->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                </div>

                <div class="confidence-section">
                    <div class="circle-chart-container">
                        <svg class="circle-chart" viewBox="0 0 100 100" width="90" height="90">
                            <circle stroke="var(--border-color)" stroke-width="8" fill="none" cx="50" cy="50" r="38" />
                            <circle stroke="{{ $color }}" stroke-width="8" stroke-dasharray="238.76" stroke-dashoffset="{{ $dashoffset }}" stroke-linecap="round" fill="none" cx="50" cy="50" r="38" style="transition: stroke-dashoffset 1s ease;" />
                        </svg>
                        <div class="circle-chart-percentage" style="color: {{ $color }};">
                            {{ $percentage }}%
                        </div>
                    </div>
                    <div class="confidence-info">
                        <div class="confidence-title">Tingkat Kecocokan Gejala (Forward Chaining)</div>
                        <div class="confidence-desc">Rasio kesesuaian fakta gejala terpilih terhadap basis aturan (rule) pakar.</div>
                        <div class="confidence-badge" style="background-color: {{ $color }}20; color: {{ $color }}; border: 1px solid {{ $color }}40;">
                            ● Status Kecocokan Rule: {{ $statusText }} ({{ $percentage }}%)
                        </div>
                    </div>
                </div>

                <div class="info-block">
                    <h4>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Kemungkinan Penyebab Utama:
                    </h4>
                    @if($candKerusakan->penyebabs->isEmpty())
                        <p style="color: var(--text-muted);">Belum ada data penyebab spesifik.</p>
                    @else
                        <ul class="info-list">
                            @foreach($candKerusakan->penyebabs as $p)
                                <li>{{ $p->deskripsi }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                @if(auth()->check())
                    <div class="info-block">
                        <h4>
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            Rekomendasi Solusi & Langkah Penanganan:
                            <span style="font-size: 0.75rem; background: rgba(56, 189, 248, 0.15); color: var(--primary); padding: 2px 8px; border-radius: 4px; font-weight: 600; margin-left: 6px; border: 1px solid rgba(56, 189, 248, 0.3);">
                                🔑 Panduan Internal ({{ auth()->user()->role === 'admin' ? 'Admin' : 'Teknisi' }})
                            </span>
                        </h4>
                        @if($candKerusakan->solusis->isEmpty())
                            <p style="color: var(--text-muted);">Belum ada data solusi spesifik.</p>
                        @else
                            <ol class="solusi-steps">
                                @foreach($candKerusakan->solusis as $s)
                                    <li>
                                        <div>{{ $s->deskripsi }}</div>
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Tidak ada indikasi gejala yang cocok dengan database rule pakar.</p>
        @endforelse

        <a href="https://wa.me/6281234567890?text=Halo%20DiagnoLap,%20saya%20ingin%20konsultasi%20pemeriksaan%20laptop" target="_blank" class="btn btn-primary" style="margin-top: 0.5rem;">
            Konsultasi dengan Teknisi Lab
        </a>
    </div>
@else
    @foreach($history->diagnosisResults as $res)
        @php
            $k = $res->kerusakan;
            $isSoftware = strtolower($k->kategori->nama_kategori ?? '') === 'software';
            $percentage = 100;
            $color = '#10b981';
            $statusText = 'Tinggi (Cocok Penuh)';

            $radius = 38;
            $circumference = 2 * M_PI * $radius;
            $dashoffset = 0;
        @endphp
        <div class="result-card {{ $isSoftware ? 'software' : '' }}">
            <div class="result-top">
                <div>
                    <div class="kerusakan-name">
                        <span class="kerusakan-code">[{{ $k->kode_kerusakan }}]</span>
                        {{ $k->nama_kerusakan }}
                    </div>
                </div>
                <span class="badge {{ $isSoftware ? 'badge-software' : 'badge-hardware' }}">
                    Kategori: {{ $k->kategori->nama_kategori ?? 'Umum' }}
                </span>
            </div>

            <!-- Bar Bulat Kecocokan Gejala (Forward Chaining) -->
            <div class="confidence-section">
                <div class="circle-chart-container">
                    <svg class="circle-chart" viewBox="0 0 100 100" width="90" height="90">
                        <circle stroke="var(--border-color)" stroke-width="8" fill="none" cx="50" cy="50" r="38" />
                        <circle stroke="{{ $color }}" stroke-width="8" stroke-dasharray="238.76" stroke-dashoffset="{{ $dashoffset }}" stroke-linecap="round" fill="none" cx="50" cy="50" r="38" style="transition: stroke-dashoffset 1s ease;" />
                    </svg>
                    <div class="circle-chart-percentage" style="color: {{ $color }};">
                        {{ $percentage }}%
                    </div>
                </div>
                <div class="confidence-info">
                    <div class="confidence-title">Tingkat Kecocokan Gejala (Forward Chaining)</div>
                    <div class="confidence-desc">Rasio kesesuaian fakta gejala terpilih terhadap basis aturan (rule) pakar.</div>
                    <div class="confidence-badge" style="background-color: {{ $color }}20; color: {{ $color }}; border: 1px solid {{ $color }}40;">
                        ● Status Kecocokan Rule: {{ $statusText }} ({{ $percentage }}%)
                    </div>
                </div>
            </div>

            <div class="info-block">
                <h4>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Kemungkinan Penyebab Utama:
                </h4>
                @if($k->penyebabs->isEmpty())
                    <p style="color: var(--text-muted);">Belum ada data penyebab spesifik.</p>
                @else
                    <ul class="info-list">
                        @foreach($k->penyebabs as $p)
                            <li>{{ $p->deskripsi }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            @if(auth()->check())
                <div class="info-block">
                    <h4>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        Rekomendasi Solusi & Langkah Penanganan:
                        <span style="font-size: 0.75rem; background: rgba(56, 189, 248, 0.15); color: var(--primary); padding: 2px 8px; border-radius: 4px; font-weight: 600; margin-left: 6px; border: 1px solid rgba(56, 189, 248, 0.3);">
                            🔑 Panduan Internal ({{ auth()->user()->role === 'admin' ? 'Admin' : 'Teknisi' }})
                        </span>
                    </h4>
                    @if($k->solusis->isEmpty())
                        <p style="color: var(--text-muted);">Belum ada data solusi spesifik.</p>
                    @else
                        <ol class="solusi-steps">
                            @foreach($k->solusis as $s)
                                <li>
                                    <div>{{ $s->deskripsi }}</div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            @else
                <div class="info-block" style="background: rgba(14, 165, 233, 0.05); border: 1px solid rgba(14, 165, 233, 0.2); border-radius: 12px; padding: 1.15rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 220px;">
                        <h4 style="color: #38bdf8; display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.35rem; font-size: 0.975rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Penanganan Spesialis Kategori Ini:
                        </h4>
                        <p style="color: var(--text-sub); font-size: 0.875rem; margin: 0; line-height: 1.5;">
                            Perbaikan kerusakan ini memerlukan peralatan laboratorium presisi. Hubungi teknisi kami untuk penanganan langsung.
                        </p>
                    </div>
                    <a href="https://wa.me/6281234567890?text=Halo%20Teknisi%20DiagnoLap,%20saya%20ingin%20konsultasi%20%26%20perbaikan%20untuk%20kerusakan%20{{ urlencode($k->nama_kerusakan) }}" target="_blank" class="btn btn-primary" style="padding: 0.55rem 1.15rem; font-size: 0.875rem; white-space: nowrap; background: #10b981; border: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        Hubungi Teknisi
                    </a>
                </div>
            @endif
        </div>
    @endforeach

    <!-- Booking Callout Box -->
    <div class="booking-callout">
        <div>
            <h4 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.35rem;">Butuh Perbaikan Langsung oleh Teknisi?</h4>
            <p style="color: var(--text-sub); font-size: 0.925rem;">Tunjukkan laporan hasil diagnosa ini kepada teknisi kami di lokasi service center atau via WhatsApp untuk penanganan cepat.</p>
        </div>
        <a href="https://wa.me/6281234567890?text=Halo%20DiagnoLap,%20saya%20ingin%20booking%20service%20berdasarkan%20hasil%20diagnosa%20ini" target="_blank" class="btn btn-primary">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            Booking Service via WhatsApp
        </a>
    </div>
@endif

<div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2.5rem; flex-wrap: wrap;">
    <a href="{{ route('diagnosis.index') }}" class="btn btn-secondary">
        🔄 Ulangi Diagnosa
    </a>
    <a href="{{ route('home') }}" class="btn btn-outline">
        🏠 Kembali ke Beranda
    </a>
</div>
@endsection
