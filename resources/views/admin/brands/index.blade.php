@extends('layouts.admin')

@section('title', 'Kelola Brand Laptop — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Kelola Brand Laptop</h1>
        <p style="color: var(--text-muted);">Merek laptop yang tersedia di sistem diagnosis.</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ panel_route('brands.create') }}" class="btn btn-primary">
            + Tambah Brand
        </a>
    @else
        <span style="font-size: 0.85rem; background: rgba(148, 163, 184, 0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.3);">
            👁️ Referensi Teknisi (Read-Only)
        </span>
    @endif
</div>

<div class="card">
    <form action="{{ panel_route('brands.index') }}" method="GET" style="margin-bottom: 1.5rem; display: flex; gap: 1rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari brand..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
        @if(request()->filled('search'))
            <a href="{{ panel_route('brands.index') }}" class="btn btn-outline" style="color: var(--text-muted);">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Brand</th>
                    <th>Jumlah Model</th>
                    @if(auth()->user()->isAdmin())
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brands->firstItem() + $loop->index }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($brand->logo_url)
                                    <div style="width: 56px; height: 38px; background: #ffffff; padding: 4px 6px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.25); flex-shrink: 0;">
                                        <img src="{{ $brand->logo_url }}" alt="{{ $brand->nama_brand }}" style="max-width: 100%; max-height: 100%; object-fit: contain;" onerror="this.onerror=null; this.parentElement.style.background='rgba(56, 189, 248, 0.12)'; this.parentElement.style.color='var(--primary)'; this.parentElement.style.border='1px solid rgba(56, 189, 248, 0.25)'; this.parentElement.innerHTML='{{ strtoupper(substr($brand->nama_brand, 0, 1)) }}';">
                                    </div>
                                @else
                                    <div style="width: 56px; height: 38px; display: inline-flex; align-items: center; justify-content: center; background: rgba(56, 189, 248, 0.12); color: var(--primary); border-radius: 8px; font-weight: 700; font-size: 1rem; border: 1px solid rgba(56, 189, 248, 0.25); flex-shrink: 0;">
                                        {{ strtoupper(substr($brand->nama_brand, 0, 1)) }}
                                    </div>
                                @endif
                                <strong>{{ $brand->nama_brand }}</strong>
                            </div>
                        </td>
                        <td>{{ $brand->laptop_models_count }} Model</td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ panel_route('brands.edit', $brand) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                        Edit
                                    </a>
                                    <form action="{{ panel_route('brands.destroy', $brand) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" data-title="Hapus Brand?" data-confirm="Brand '{{ $brand->nama_brand }}' dan semua model terkait akan dihapus permanen." onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" style="text-align: center; color: var(--text-muted);">Belum ada data brand.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $brands->links() }}
    </div>
</div>
@endsection
