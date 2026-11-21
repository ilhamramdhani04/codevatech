@extends('layouts.admin')

@section('title', 'Detail Riwayat Sesi — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Detail Sesi Diagnosis #{{ $riwayat->id }}</h1>
        <p style="color: var(--text-muted);">
            @if($riwayat->user)
                Teknisi: <strong>{{ $riwayat->user->name }}</strong>
                @if($riwayat->nama_pengguna)
                    | Customer: <strong>{{ $riwayat->nama_pengguna }}</strong>
                @endif
            @else
                Pengguna: <strong>{{ $riwayat->nama_pengguna ?? 'Guest (Anonim)' }}</strong>
            @endif
            | Waktu: {{ $riwayat->tanggal_diagnosis->format('d M Y, H:i') }} WIB
            @if($riwayat->laptop_display)
                | Laptop: <strong style="color: var(--primary);">{{ $riwayat->laptop_display }}</strong>
            @endif
        </p>
    </div>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        @if(auth()->user()->isTeknisi())
            <a href="{{ panel_route('riwayat.pdf', $riwayat) }}" class="btn btn-primary" style="background: #10b981;">
                📥 Download PDF
            </a>
        @endif
        <a href="{{ panel_route('riwayat.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<div class="card">
    <h3>🩺 Gejala yang Dipilih Pengguna ({{ $riwayat->diagnosisGejala->count() }})</h3>
    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 1rem;">
        @foreach($riwayat->diagnosisGejala as $dg)
            <div style="background: rgba(15,23,42,0.6); padding: 0.4rem 0.8rem; border-radius: 0.5rem; border: 1px solid var(--border); font-size: 0.9rem;">
                <strong style="color: var(--primary);">{{ $dg->gejala->kode_gejala }}</strong> — {{ $dg->gejala->nama_gejala }}
            </div>
        @endforeach
    </div>
</div>

<div class="card">
    <h3>🎯 Hasil Inferensi Forward Chaining</h3>
    @if($riwayat->diagnosisResults->isEmpty())
        <p style="color: var(--text-muted); margin-top: 0.5rem;">Tidak ada kerusakan yang match dengan kombinasi gejala ini.</p>
    @else
        <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
            @foreach($riwayat->diagnosisResults as $res)
                @php $k = $res->kerusakan; @endphp
                <div style="background: rgba(15,23,42,0.6); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid var(--border); border-left: 4px solid var(--primary);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="font-size: 1.2rem;">
                            <span style="color: var(--primary);">[{{ $k->kode_kerusakan }}]</span> {{ $k->nama_kerusakan }}
                        </h4>
                        <span class="badge {{ strtolower($k->kategori->nama_kategori ?? '') === 'software' ? 'badge-software' : 'badge-hardware' }}">
                            {{ $k->kategori->nama_kategori ?? '-' }}
                        </span>
                    </div>

                    <div style="margin-top: 1rem;">
                        <strong>Penyebab:</strong>
                        <ul style="margin-left: 1.2rem; color: var(--text-muted); margin-top: 0.25rem;">
                            @foreach($k->penyebabs as $p)
                                <li>{{ $p->deskripsi }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div style="margin-top: 0.75rem;">
                        <strong>Solusi:</strong>
                        <ol style="margin-left: 1.2rem; color: var(--text-muted); margin-top: 0.25rem;">
                            @foreach($k->solusis as $s)
                                <li>{{ $s->deskripsi }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
