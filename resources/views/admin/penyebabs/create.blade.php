@extends('layouts.admin')

@section('title', 'Tambah Penyebab — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Tambah Penyebab untuk {{ $kerusakan->kode_kerusakan }}</h1>
    <a href="{{ panel_route('kerusakans.show', $kerusakan) }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('penyebabs.store', $kerusakan) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="deskripsi">Deskripsi Penyebab</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi penyebab..." required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Penyebab</button>
    </form>
</div>
@endsection
