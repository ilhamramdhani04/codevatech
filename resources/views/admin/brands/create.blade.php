@extends('layouts.admin')

@section('title', 'Tambah Brand — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Tambah Brand Baru</h1>
    <a href="{{ panel_route('brands.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('brands.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_brand">Nama Brand</label>
            <input type="text" name="nama_brand" id="nama_brand" class="form-control" placeholder="Contoh: ASUS, Lenovo, HP" value="{{ old('nama_brand') }}" required>
            @error('nama_brand')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="logo_url">URL Logo (Opsional)</label>
            <input type="text" name="logo_url" id="logo_url" class="form-control" placeholder="https://example.com/logo.png" value="{{ old('logo_url') }}">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.35rem;">
                💡 Logo akan ditampilkan sebagai thumbnail di tabel Kelola Brand Admin.
            </span>
            @error('logo_url')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Brand</button>
    </form>
</div>
@endsection
