@extends('layouts.admin')

@section('title', 'Tambah User Baru — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Tambah User / Teknisi Baru</h1>
        <p style="color: var(--text-muted);">Buat akun baru untuk Administrator atau Teknisi laboratorium.</p>
    </div>
    <a href="{{ panel_route('users.index') }}" class="btn btn-secondary">
        &larr; Kembali
    </a>
</div>

<div class="card" style="max-width: 650px;">
    <form action="{{ panel_route('users.store') }}" method="POST">
        @csrf

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nama Lengkap <span style="color: red;">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Budi Santoso">
            @error('name')
                <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email Login <span style="color: red;">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror" placeholder="teknisi@diagnolap.com">
            @error('email')
                <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Role Hak Akses <span style="color: red;">*</span></label>
            <select name="role" required class="form-control @error('role') is-invalid @enderror">
                <option value="teknisi" selected>Teknisi Lab (Operator Diagnosis & Perbaikan)</option>
                <option value="admin" disabled>Super Admin (🔒 Kuota Terisi — Maksimal 1 Super Admin)</option>
            </select>
            @error('role')
                <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Password <span style="color: red;">*</span></label>
            <input type="password" name="password" required class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
            @error('password')
                <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.75rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Konfirmasi Password <span style="color: red;">*</span></label>
            <input type="password" name="password_confirmation" required class="form-control" placeholder="Ulangi password di atas">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan User</button>
            <a href="{{ panel_route('users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
