@extends('layouts.admin')

@section('title', 'Edit Brand — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Edit Brand</h1>
    <a href="{{ panel_route('brands.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('brands.update', $brand) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_brand">Nama Brand</label>
            <input type="text" name="nama_brand" id="nama_brand" class="form-control" value="{{ old('nama_brand', $brand->nama_brand) }}" required>
            @error('nama_brand')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="logo_url">URL Logo (Opsional)</label>
            <input type="text" name="logo_url" id="logo_url" class="form-control" value="{{ old('logo_url', $brand->logo_url) }}" placeholder="https://example.com/logo.png">
            @if($brand->logo_url)
                <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.75rem; background: rgba(15, 23, 42, 0.4); padding: 0.5rem 0.75rem; border-radius: 6px; border: 1px solid var(--border);">
                    <span style="font-size: 0.8rem; color: var(--text-muted);">Preview Logo saat ini:</span>
                    <div style="width: 70px; height: 44px; background: #ffffff; padding: 4px 8px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                        <img src="{{ $brand->logo_url }}" alt="Preview {{ $brand->nama_brand }}" style="max-width: 100%; max-height: 100%; object-fit: contain;" onerror="this.parentElement.style.display='none'">
                    </div>
                </div>
            @endif
            @error('logo_url')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Brand</button>
    </form>
</div>
@endsection
