@extends('layouts.admin')

@section('title', 'Tambah Model Laptop — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Tambah Model Laptop Baru</h1>
    <a href="{{ panel_route('laptop-models.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('laptop-models.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="brand_id">Brand Laptop</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">— Pilih Brand —</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->nama_brand }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama_model">Nama Model</label>
            <input type="text" name="nama_model" id="nama_model" class="form-control" placeholder="Contoh: ROG Strix G15, ThinkPad X1 Carbon" value="{{ old('nama_model') }}" required>
            @error('nama_model')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="seri">Kode Seri (Opsional)</label>
            <input type="text" name="seri" id="seri" class="form-control" placeholder="Contoh: G513, 21HM, FX506" value="{{ old('seri') }}">
            @error('seri')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="kategori_laptop">Kategori Laptop</label>
            <select name="kategori_laptop" id="kategori_laptop" class="form-control" required>
                <option value="mainstream" {{ old('kategori_laptop') == 'mainstream' ? 'selected' : '' }}>Mainstream / Harian</option>
                <option value="gaming" {{ old('kategori_laptop') == 'gaming' ? 'selected' : '' }}>Gaming</option>
                <option value="business" {{ old('kategori_laptop') == 'business' ? 'selected' : '' }}>Business / Kerja</option>
                <option value="ultrabook" {{ old('kategori_laptop') == 'ultrabook' ? 'selected' : '' }}>Ultrabook / Tipis</option>
                <option value="workstation" {{ old('kategori_laptop') == 'workstation' ? 'selected' : '' }}>Workstation / Berat</option>
            </select>
            @error('kategori_laptop')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tahun_rilis">Tahun Rilis (Opsional)</label>
            <input type="number" name="tahun_rilis" id="tahun_rilis" class="form-control" placeholder="Contoh: 2023" value="{{ old('tahun_rilis') }}" min="2000" max="{{ date('Y') + 1 }}">
            @error('tahun_rilis')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Model</button>
    </form>
</div>
@endsection
