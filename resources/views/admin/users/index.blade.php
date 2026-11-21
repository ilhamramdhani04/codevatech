@extends('layouts.admin')

@section('title', 'Kelola User & Teknisi — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Kelola User & Teknisi</h1>
        <p style="color: var(--text-muted);">Manajemen akun Administrator dan Teknisi laboratorium.</p>
    </div>
    <a href="{{ panel_route('users.create') }}" class="btn btn-primary">
        + Tambah User Baru
    </a>
</div>

{{-- Filter & Search --}}
<div class="card" style="margin-bottom: 1.5rem; padding: 1.25rem;">
    <form action="{{ panel_route('users.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="form-control" style="flex: 1; min-width: 200px;">
        <select name="role" class="form-control" style="width: 180px;">
            <option value="">-- Semua Role --</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="teknisi" {{ request('role') === 'teknisi' ? 'selected' : '' }}>Teknisi</option>
        </select>
        <button type="submit" class="btn btn-secondary">Filter</button>
        @if(request()->hasAny(['search', 'role']))
            <a href="{{ panel_route('users.index') }}" class="btn btn-secondary" style="background-color: transparent;">Reset</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if($user->id === auth()->id())
                                <span style="font-size: 0.75rem; background: var(--primary); color: #fff; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Anda</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span style="padding: 3px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; background: rgba(14, 165, 233, 0.15); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.3);">
                                    Super Admin
                                </span>
                            @else
                                <span style="padding: 3px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3);">
                                    Teknisi Lab
                                </span>
                            @endif
                        </td>
                        <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ panel_route('users.edit', $user) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                    Edit
                                </a>
                                @if($user->id !== auth()->id() && !$user->isAdmin())
                                    <form action="{{ panel_route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" data-title="Hapus User?" data-confirm="User '{{ $user->name }}' akan dihapus permanen." onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
    <div style="margin-top: 1.5rem;">
        {{ $users->links() }}
    </div>
@endif
@endsection
