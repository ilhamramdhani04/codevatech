@extends('layouts.admin')

@section('title', 'Edit Solusi — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Edit Solusi</h1>
    <a href="{{ panel_route('kerusakans.show', $kerusakan) }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('solusis.update', [$kerusakan, $solusi]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="urutan">Urutan Langkah Solusi</label>
            <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan', $solusi->urutan) }}" min="1" required>
            @error('urutan')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi Solusi / Langkah Penanganan</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $solusi->deskripsi) }}</textarea>
            @error('deskripsi')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Solusi</button>
    </form>
</div>
@endsection
