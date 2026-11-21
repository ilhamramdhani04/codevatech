<div class="form-group">
    <label for="diagnosis_group">Kelompok Diagnosis</label>
    <select name="diagnosis_group" id="diagnosis_group" class="form-control">
        <option value="">Belum dikelompokkan</option>
        @foreach(\App\Models\Gejala::DIAGNOSIS_GROUPS as $value => $label)
            <option value="{{ $value }}" @selected(old('diagnosis_group', $gejala->diagnosis_group ?? '') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.4rem;">Menentukan tab gejala di halaman diagnosis. Semua gejala tetap tampil di tab Semua Gejala; status Sering Terjadi diatur terpisah.</p>
    @error('diagnosis_group')
        <div style="color: var(--danger); font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div>
    @enderror
</div>
