@extends('layouts.admin')

@section('title', 'Tambah Rule — CODEVA TECH')

@section('content')
<div class="header-title">
    <h1>Tambah Rule Baru</h1>
    <a href="{{ panel_route('rules.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<form action="{{ panel_route('rules.store') }}" method="POST">
    @csrf
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
        <div class="card">
            <h3>Informasi Rule</h3>
            <div class="form-group" style="margin-top: 1rem;">
                <label for="kode_rule">Kode Rule (Format: R01, R02, dst)</label>
                <input type="text" name="kode_rule" id="kode_rule" class="form-control" placeholder="R01" value="{{ old('kode_rule') }}" required>
                @error('kode_rule')
                    <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kerusakan_id">Hasil Kerusakan (THEN)</label>
                <select name="kerusakan_id" id="kerusakan_id" class="form-control" required>
                    <option value="">-- Pilih Kerusakan --</option>
                    @foreach($kerusakans as $k)
                        <option value="{{ $k->id }}" {{ old('kerusakan_id') == $k->id ? 'selected' : '' }}>
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
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Catatan internal admin...">{{ old('keterangan') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                Simpan Rule
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
                            <input type="checkbox" name="gejala_ids[]" value="{{ $g->id }}" {{ is_array(old('gejala_ids')) && in_array($g->id, old('gejala_ids')) ? 'checked' : '' }}>
                            <strong style="color: var(--primary);">{{ $g->kode_gejala }}</strong> — {{ $g->nama_gejala }}
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; color: var(--danger); cursor: pointer; margin: 0;">
                            <input type="checkbox" name="is_negated[]" value="{{ $g->id }}" {{ is_array(old('is_negated')) && in_array($g->id, old('is_negated')) ? 'checked' : '' }}>
                            NOT (Tidak Ada)
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection
