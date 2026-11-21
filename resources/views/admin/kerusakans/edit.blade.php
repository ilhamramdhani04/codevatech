@extends('layouts.admin')

@section('title', 'Edit Kerusakan — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Edit Data Kerusakan</h1>
    <a href="{{ panel_route('kerusakans.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('kerusakans.update', $kerusakan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control" required>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id', $kerusakan->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
            @error('kategori_id')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="kode_kerusakan">Kode Kerusakan</label>
            <input type="text" name="kode_kerusakan" id="kode_kerusakan" class="form-control" value="{{ old('kode_kerusakan', $kerusakan->kode_kerusakan) }}" required>
            @error('kode_kerusakan')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="nama_kerusakan">Nama Kerusakan</label>
            <input type="text" name="nama_kerusakan" id="nama_kerusakan" class="form-control" value="{{ old('nama_kerusakan', $kerusakan->nama_kerusakan) }}" required>
            @error('nama_kerusakan')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Kerusakan</button>
    </form>
</div>
@endsection
