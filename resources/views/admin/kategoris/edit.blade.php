@extends('layouts.admin')

@section('title', 'Edit Kategori — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Edit Kategori</h1>
    <a href="{{ panel_route('kategoris.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('kategoris.update', $kategori) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_kategori">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
            @error('nama_kategori')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Kategori</button>
    </form>
</div>
@endsection
