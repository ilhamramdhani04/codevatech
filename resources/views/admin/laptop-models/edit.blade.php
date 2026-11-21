@extends('layouts.admin')

@section('title', 'Edit Model Laptop — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Edit Model Laptop</h1>
    <a href="{{ panel_route('laptop-models.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ panel_route('laptop-models.update', $laptop_model) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="brand_id">Brand Laptop</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">— Pilih Brand —</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id', $laptop_model->brand_id) == $brand->id ? 'selected' : '' }}>
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
            <input type="text" name="nama_model" id="nama_model" class="form-control" value="{{ old('nama_model', $laptop_model->nama_model) }}" required>
            @error('nama_model')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="seri">Kode Seri (Opsional)</label>
            <input type="text" name="seri" id="seri" class="form-control" value="{{ old('seri', $laptop_model->seri) }}">
            @error('seri')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="kategori_laptop">Kategori Laptop</label>
            <select name="kategori_laptop" id="kategori_laptop" class="form-control" required>
                @foreach(['mainstream' => 'Mainstream / Harian', 'gaming' => 'Gaming', 'business' => 'Business / Kerja', 'ultrabook' => 'Ultrabook / Tipis', 'workstation' => 'Workstation / Berat'] as $key => $label)
                    <option value="{{ $key }}" {{ old('kategori_laptop', $laptop_model->kategori_laptop) == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('kategori_laptop')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tahun_rilis">Tahun Rilis (Opsional)</label>
            <input type="number" name="tahun_rilis" id="tahun_rilis" class="form-control" value="{{ old('tahun_rilis', $laptop_model->tahun_rilis) }}" min="2000" max="{{ date('Y') + 1 }}">
            @error('tahun_rilis')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Model</button>
    </form>
</div>
@endsection
