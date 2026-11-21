@extends('layouts.admin')

@section('title', 'Edit Rule — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Edit Rule {{ $rule->kode_rule }}</h1>
    <a href="{{ panel_route('rules.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

@php
    $selectedGejalaIds = old('gejala_ids', $rule->ruleGejala->pluck('gejala_id')->toArray());
    $negatedGejalaIds  = old('is_negated', $rule->ruleGejala->where('is_negated', true)->pluck('gejala_id')->toArray());
@endphp

<form action="{{ panel_route('rules.update', $rule) }}" method="POST">
    @csrf
    @method('PUT')
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
        <div class="card">
            <h3>Informasi Rule</h3>
            <div class="form-group" style="margin-top: 1rem;">
                <label for="kode_rule">Kode Rule</label>
                <input type="text" name="kode_rule" id="kode_rule" class="form-control" value="{{ old('kode_rule', $rule->kode_rule) }}" required>
                @error('kode_rule')
                    <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kerusakan_id">Hasil Kerusakan (THEN)</label>
                <select name="kerusakan_id" id="kerusakan_id" class="form-control" required>
                    @foreach($kerusakans as $k)
                        <option value="{{ $k->id }}" {{ old('kerusakan_id', $rule->kerusakan_id) == $k->id ? 'selected' : '' }}>
                            [{{ $k->kode_kerusakan }}] {{ $k->nama_kerusakan }}
                        </option>
                    @endforeach
                </select>
                @error('kerusakan_id')
                    <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan Rule (Opsional)</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ old('keterangan', $rule->keterangan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                Update Rule
            </button>
        </div>

        <div class="card">
            <h3>Kondisi Gejala (IF)</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">
                Centang gejala yang menjadi syarat rule ini. Jika gejala tersebut <strong>TIDAK BOLEH muncul</strong>, centang juga opsi <em>NOT Logic</em>.
            </p>

            @error('gejala_ids')
                <div class="alert alert-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem; margin-bottom: 1rem;">{{ $message }}</div>
            @enderror

            <div style="max-height: 450px; overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem; padding-right: 0.5rem;">
                @foreach($gejalas as $g)
                    <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(15,23,42,0.5); padding: 0.6rem 0.85rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin: 0; font-size: 0.9rem;">
                            <input type="checkbox" name="gejala_ids[]" value="{{ $g->id }}" {{ in_array($g->id, $selectedGejalaIds) ? 'checked' : '' }}>
                            <strong style="color: var(--primary);">{{ $g->kode_gejala }}</strong> — {{ $g->nama_gejala }}
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; color: var(--danger); cursor: pointer; margin: 0;">
                            <input type="checkbox" name="is_negated[]" value="{{ $g->id }}" {{ in_array($g->id, $negatedGejalaIds) ? 'checked' : '' }}>
                            NOT (Tidak Ada)
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection
