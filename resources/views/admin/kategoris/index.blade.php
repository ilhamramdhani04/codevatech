@extends('layouts.admin')

@section('title', 'Kelola Kategori — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Kelola Kategori Kerusakan</h1>
        <p style="color: var(--text-muted);">Kategori utama (Hardware / Software).</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ panel_route('kategoris.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    @else
        <span style="font-size: 0.85rem; background: rgba(148, 163, 184, 0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.3);">
            👁️ Referensi Teknisi (Read-Only)
        </span>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Kerusakan</th>
                    @if(auth()->user()->isAdmin())
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $kategori->nama_kategori }}</strong></td>
                        <td>{{ $kategori->kerusakans_count }} Kerusakan</td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ panel_route('kategoris.edit', $kategori) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                        Edit
                                    </a>
                                    <form action="{{ panel_route('kategoris.destroy', $kategori) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" data-title="Hapus Kategori?" data-confirm="Kategori '{{ $kategori->nama_kategori }}' akan dihapus permanen." onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" style="text-align: center; color: var(--text-muted);">Belum ada data kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


