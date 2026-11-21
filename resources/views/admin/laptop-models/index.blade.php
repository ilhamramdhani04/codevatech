@extends('layouts.admin')

@section('title', 'Kelola Model Laptop — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Kelola Model Laptop</h1>
        <p style="color: var(--text-muted);">Daftar model laptop per brand untuk diagnosa spesifik.</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ panel_route('laptop-models.create') }}" class="btn btn-primary">
            + Tambah Model
        </a>
    @else
        <span style="font-size: 0.85rem; background: rgba(148, 163, 184, 0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.3);">
            👁️ Referensi Teknisi (Read-Only)
        </span>
    @endif
</div>

<div class="card">
    <form action="{{ panel_route('laptop-models.index') }}" method="GET" style="margin-bottom: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
        <input type="text" name="search" class="form-control" placeholder="Cari model / seri / brand..." value="{{ request('search') }}" style="flex: 2; min-width: 200px;">
        <select name="brand_id" class="form-control" style="flex: 1; min-width: 150px;">
            <option value="">-- Semua Brand --</option>
            @foreach($brands as $b)
                <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_brand }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Cari & Filter</button>
        @if(request()->filled('search') || request()->filled('brand_id'))
            <a href="{{ panel_route('laptop-models.index') }}" class="btn btn-outline" style="color: var(--text-muted);">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Brand</th>
                    <th>Nama Model</th>
                    <th>Seri</th>
                    <th>Kategori</th>
                    <th>Tahun Rilis</th>
                    @if(auth()->user()->isAdmin())
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($models as $model)
                    <tr>
                        <td>{{ $models->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $model->brand->nama_brand ?? '-' }}</strong></td>
                        <td>{{ $model->nama_model }}</td>
                        <td>{{ $model->seri ?? '-' }}</td>
                        <td>
                            <span class="badge badge-hardware" style="text-transform: capitalize;">
                                {{ $model->kategori_laptop }}
                            </span>
                        </td>
                        <td>{{ $model->tahun_rilis ?? '-' }}</td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ panel_route('laptop-models.edit', $model) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                        Edit
                                    </a>
                                    <form action="{{ panel_route('laptop-models.destroy', $model) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" data-title="Hapus Model?" data-confirm="Model laptop '{{ $model->nama_model }}' akan dihapus permanen." onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}" style="text-align: center; color: var(--text-muted);">Belum ada data model laptop.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $models->links() }}
    </div>
</div>
@endsection


