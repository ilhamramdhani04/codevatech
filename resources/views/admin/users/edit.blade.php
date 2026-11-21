@extends('layouts.admin')

@section('title', 'Edit User — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Edit User: {{ $user->name }}</h1>
        <p style="color: var(--text-muted);">Ubah informasi profil, role, atau reset password user.</p>
    </div>
    <a href="{{ panel_route('users.index') }}" class="btn btn-secondary">
        &larr; Kembali
    </a>
</div>

<div class="card" style="max-width: 650px;">
    <form action="{{ panel_route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nama Lengkap <span style="color: red;">*</span></label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email Login <span style="color: red;">*</span></label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Role Hak Akses <span style="color: red;">*</span></label>
            @if($user->isTeknisi())
                <select name="role" required class="form-control @error('role') is-invalid @enderror">
                    <option value="teknisi" selected>Teknisi Lab (Operator Diagnosis & Perbaikan)</option>
                    <option value="admin" disabled>Super Admin (🔒 Terkunci — Maksimal 1 Super Admin)</option>
                </select>
            @else
                <select name="role" required class="form-control @error('role') is-invalid @enderror">
                    <option value="admin" selected>Super Admin (Pengelola Master Data & User)</option>
                    <option value="teknisi" disabled>Teknisi Lab (🔒 Super Admin Utama tidak dapat diubah)</option>
                </select>
            @endif
            @error('role')
                <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin: 1.5rem 0; padding: 1rem; border: 1px solid var(--border-color); border-radius: 8px; background: rgba(15, 22, 41, 0.5);">
            <h4 style="font-size: 0.95rem; margin-bottom: 0.5rem; color: var(--accent);">Reset Password (Opsional)</h4>
            <p style="font-size: 0.825rem; color: var(--text-muted); margin-bottom: 1rem;">Biarkan kosong jika tidak ingin mengubah password user.</p>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.35rem; font-size: 0.9rem;">Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                @error('password')
                    <p style="color: #fca5a5; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: block; margin-bottom: 0.35rem; font-size: 0.9rem;">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Perbarui User</button>
            <a href="{{ panel_route('users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
