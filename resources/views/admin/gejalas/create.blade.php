@extends('layouts.admin')

@section('title', 'Tambah Gejala — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Tambah Gejala Baru</h1>
    <a href="{{ panel_route('gejalas.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('gejalas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="kode_gejala">Kode Gejala (Format: G01, G02, dst)</label>
            <input type="text" name="kode_gejala" id="kode_gejala" class="form-control" placeholder="G01" value="{{ old('kode_gejala') }}" required>
            @error('kode_gejala')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="nama_gejala">Deskripsi Nama Gejala</label>
            <textarea name="nama_gejala" id="nama_gejala" class="form-control" rows="3" placeholder="Masukkan indikasi / gejala yang dialami..." required>{{ old('nama_gejala') }}</textarea>
            @error('nama_gejala')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group" style="margin-top: 1rem; margin-bottom: 1.5rem;">
            <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer; color: var(--text-main); font-weight: 600;">
                <input type="checkbox" name="is_frequent" value="1" {{ old('is_frequent') ? 'checked' : '' }} style="width: 1.15rem; height: 1.15rem; accent-color: var(--primary);">
                <span>🔥 Tandai sebagai Gejala Sering Terjadi (Tampil di Tab Paling Sering Terjadi)</span>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Gejala</button>
    </form>
</div>
@endsection
