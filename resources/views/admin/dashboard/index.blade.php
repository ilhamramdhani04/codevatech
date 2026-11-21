@extends('layouts.admin')

@section('title', (auth()->user()->isTeknisi() ? 'Dashboard Teknisi' : 'Dashboard Admin') . ' — CODEVA TECH')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .stat-icon {
        width: 3.2rem;
        height: 3.2rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background-color: rgba(56, 189, 248, 0.1);
        color: var(--primary);
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.85rem;
    }
</style>

<div class="header-title">
    <div>
        <h1>Dashboard Sistem Pakar</h1>
        <p style="color: var(--text-muted);">Ringkasan data & statistik aktivitas sistem saat ini.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">🏢</div>
        <div>
            <div class="stat-value">{{ $stats['total_brand'] }}</div>
            <div class="stat-label">Brand Laptop</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💻</div>
        <div>
            <div class="stat-value">{{ $stats['total_model'] }}</div>
            <div class="stat-label">Model Laptop</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🩺</div>
        <div>
            <div class="stat-value">{{ $stats['total_gejala'] }}</div>
            <div class="stat-label">Master Gejala</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🛠️</div>
        <div>
            <div class="stat-value">{{ $stats['total_kerusakan'] }}</div>
            <div class="stat-label">Master Kerusakan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⚡</div>
        <div>
            <div class="stat-value">{{ $stats['total_rule'] }}</div>
            <div class="stat-label">Rule Inference</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📜</div>
        <div>
            <div class="stat-value">{{ $stats['total_diagnosis'] }}</div>
            <div class="stat-label">Total Diagnosis</div>
        </div>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 1.25rem;">📜 Diagnosis Terakhir</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Nama Pengguna</th>
                    <th>Laptop</th>
                    <th>Hasil Kerusakan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentDiagnosis as $history)
                    <tr>
                        <td>{{ $history->tanggal_diagnosis->format('d M Y, H:i') }}</td>
                        <td>
                            @if($history->user)
                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 0.75rem; display: block; margin-bottom: 2px;">👨‍🔧 {{ $history->user->name }}</span>
                                <strong>{{ $history->nama_pengguna ?? '—' }}</strong>
                            @else
                                <strong>{{ $history->nama_pengguna ?? 'Guest' }}</strong>
                            @endif
                        </td>
                        <td>
                            @if($history->laptop_display)
                                <span class="gejala-code" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">💻 {{ $history->laptop_display }}</span>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td>
                            @forelse($history->diagnosisResults as $res)
                                <span class="badge {{ strtolower($res->kerusakan->kategori->nama_kategori ?? '') === 'software' ? 'badge-software' : 'badge-hardware' }}">
                                    {{ $res->kerusakan->nama_kerusakan }}
                                </span>
                            @empty
                                <span style="color: var(--text-muted);">Tidak Ditemukan</span>
                            @endforelse
                        </td>
                        <td>
                            <a href="{{ panel_route('riwayat.show', $history) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada riwayat diagnosis.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
