@extends('layouts.admin')

@section('title', 'Master Kerusakan — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Master Data Kerusakan</h1>
        <p style="color: var(--text-muted);">Daftar jenis kerusakan hardware & software.</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ panel_route('kerusakans.create') }}" class="btn btn-primary">
            + Tambah Kerusakan
        </a>
    @else
        <span style="font-size: 0.85rem; background: rgba(148, 163, 184, 0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.3);">
            👁️ Referensi Teknisi (Read-Only)
        </span>
    @endif
</div>

<div class="card">
    <form action="{{ panel_route('kerusakans.index') }}" method="GET" style="margin-bottom: 1.5rem; display: flex; gap: 1rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari kode/nama kerusakan..." value="{{ request('search') }}" style="flex: 2;">
        <select name="kategori_id" class="form-control" style="flex: 1;">
            <option value="">-- Semua Kategori --</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Filter</button>
        @if(request()->filled('search') || request()->filled('kategori_id'))
            <a href="{{ panel_route('kerusakans.index') }}" class="btn btn-outline" style="color: var(--text-muted);">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kerusakan</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kerusakans as $kerusakan)
                    @php
                        $isSoftware = strtolower($kerusakan->kategori->nama_kategori ?? '') === 'software';
                    @endphp
                    <tr>
                        <td>{{ $kerusakans->firstItem() + $loop->index }}</td>
                        <td><strong style="color: var(--primary);">{{ $kerusakan->kode_kerusakan }}</strong></td>
                        <td>
                            <a href="{{ panel_route('kerusakans.show', $kerusakan) }}" style="color: var(--text-main); font-weight: 600; text-decoration: none;">
                                {{ $kerusakan->nama_kerusakan }} ↗
                            </a>
                        </td>
                        <td>
                            <span class="badge {{ $isSoftware ? 'badge-software' : 'badge-hardware' }}">
                                {{ $kerusakan->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ panel_route('kerusakans.show', $kerusakan) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                    Detail & Solusi
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ panel_route('kerusakans.edit', $kerusakan) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                        Edit
                                    </a>
                                    <form action="{{ panel_route('kerusakans.destroy', $kerusakan) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" data-title="Hapus Kerusakan?" data-confirm="Kerusakan '{{ $kerusakan->nama_kerusakan }}' akan dihapus permanen." onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Belum ada data kerusakan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $kerusakans->links() }}
    </div>
</div>
@endsection


