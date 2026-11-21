@extends('layouts.admin')

@section('title', 'Riwayat Diagnosis — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Riwayat Diagnosis Sesi Pengguna</h1>
        <p style="color: var(--text-muted);">Monitoring, cetak laporan perbaikan, dan evaluasi histori diagnosis.</p>
    </div>
</div>

<div class="card">
    <form action="{{ panel_route('riwayat.index') }}" method="GET" style="margin-bottom: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
        <input type="text" name="search" class="form-control" placeholder="Cari nama pengguna / laptop..." value="{{ request('search') }}" style="flex: 2; min-width: 200px;">
        <select name="brand_id" class="form-control" style="flex: 1; min-width: 150px;">
            <option value="">— Semua Brand —</option>
            @foreach($brands as $b)
                <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_brand }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Cari & Filter</button>
        @if(request()->filled('search') || request()->filled('brand_id'))
            <a href="{{ panel_route('riwayat.index') }}" class="btn btn-outline" style="color: var(--text-muted);">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu Diagnosis</th>
                    <th>Nama Pengguna / Guest</th>
                    <th>Laptop</th>
                    <th>Hasil Kerusakan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                    <tr>
                        <td>{{ $histories->firstItem() + $loop->index }}</td>
                        <td>{{ $history->tanggal_diagnosis ? $history->tanggal_diagnosis->format('d M Y, H:i') : '-' }} WIB</td>
                        <td>
                            @if($history->user)
                                <div>
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 0.75rem;">👨‍🔧 {{ $history->user->name }}</span>
                                </div>
                                @if($history->nama_pengguna)
                                    <strong>{{ $history->nama_pengguna }}</strong>
                                    <span style="color: var(--text-muted); font-size: 0.8rem;">(customer)</span>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">— Tanpa nama customer —</span>
                                @endif
                            @else
                                <strong>{{ $history->nama_pengguna ?? 'Guest (Anonim)' }}</strong>
                                <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; margin-left: 4px; font-size: 0.75rem;">(Guest)</span>
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
                                    [{{ $res->kerusakan->kode_kerusakan }}] {{ $res->kerusakan->nama_kerusakan }}
                                </span>
                            @empty
                                <span style="color: var(--text-muted);">Tidak Match</span>
                            @endforelse
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.4rem;">
                                <a href="{{ panel_route('riwayat.show', $history) }}" class="btn btn-secondary" style="padding: 0.3rem 0.65rem; font-size: 0.8rem;">
                                    Detail
                                </a>
                                @if(auth()->user()->isTeknisi())
                                    <a href="{{ panel_route('riwayat.pdf', $history) }}" class="btn btn-primary" style="padding: 0.3rem 0.65rem; font-size: 0.8rem; background: #10b981;">
                                        📥 PDF
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada riwayat diagnosis.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $histories->links() }}
    </div>
</div>
@endsection
