@extends('layouts.admin')

@section('title', 'Tambah Solusi — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Tambah Solusi untuk {{ $kerusakan->kode_kerusakan }}</h1>
    <a href="{{ panel_route('kerusakans.show', $kerusakan) }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('solusis.store', $kerusakan) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="urutan">Urutan Langkah Solusi</label>
            <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan', $nextUrutan) }}" min="1" required>
            @error('urutan')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi Solusi / Langkah Penanganan</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi langkah penanganan..." required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Solusi</button>
    </form>
</div>
@endsection
