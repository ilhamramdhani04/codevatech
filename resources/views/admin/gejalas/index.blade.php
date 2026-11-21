@extends('layouts.admin')

@section('title', 'Master Gejala — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Master Data Gejala</h1>
        <p style="color: var(--text-muted);">Daftar gejala awal (fakta) untuk mesin Forward Chaining.</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ panel_route('gejalas.create') }}" class="btn btn-primary">
            + Tambah Gejala
        </a>
    @else
        <span style="font-size: 0.85rem; background: rgba(148, 163, 184, 0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.3);">
            👁️ Referensi Teknisi (Read-Only)
        </span>
    @endif
</div>

<div class="card">
    <form action="{{ panel_route('gejalas.index') }}" method="GET" style="margin-bottom: 1.5rem; display: flex; gap: 1rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari kode atau nama gejala..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
        @if(request()->filled('search'))
            <a href="{{ panel_route('gejalas.index') }}" class="btn btn-outline" style="color: var(--text-muted);">Reset</a>
        @endif
    </form>

    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">Kelompok Diagnosis mengatur tab pada halaman diagnosis dan terpisah dari status Sering Terjadi.</p>
    @error('diagnosis_group')
        <p role="alert" style="color: var(--danger);">{{ $message }}</p>
    @enderror
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Gejala</th>
                    <th>Kelompok Diagnosis</th>
                    <th>Status Sering Terjadi (Tab 🔥)</th>
                    @if(auth()->user()->isAdmin())
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($gejalas as $gejala)
                    <tr>
                        <td>{{ $gejalas->firstItem() + $loop->index }}</td>
                        <td><strong style="color: var(--primary);">{{ $gejala->kode_gejala }}</strong></td>
                        <td>{{ $gejala->nama_gejala }}</td>
                        <td>
                            @if(auth()->user()->isAdmin())
                                <form action="{{ panel_route('gejalas.update-group', $gejala) }}" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="diagnosis_group" class="form-control" aria-label="Kelompok diagnosis {{ $gejala->kode_gejala }}" style="min-width: 190px;">
                                        <option value="">Belum dikelompokkan</option>
                                        @foreach(\App\Models\Gejala::DIAGNOSIS_GROUPS as $value => $label)
                                            <option value="{{ $value }}" @selected($gejala->diagnosis_group === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" aria-label="Simpan kelompok {{ $gejala->kode_gejala }}">Simpan</button>
                                </form>
                            @else
                                {{ \App\Models\Gejala::DIAGNOSIS_GROUPS[$gejala->diagnosis_group] ?? 'Belum dikelompokkan' }}
                            @endif
                        </td>
                        <td>
                            @if(auth()->user()->isAdmin())
                                <form action="{{ panel_route('gejalas.toggle-frequent', $gejala) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;" title="Klik untuk mengubah status Sering Terjadi">
                                        @if($gejala->is_frequent)
                                            <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.3rem 0.65rem; border-radius: 50px; font-weight: 700; font-size: 0.78rem;">
                                                🔥 Sering Terjadi
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(148, 163, 184, 0.12); color: var(--text-muted); border: 1px solid var(--border); padding: 0.3rem 0.65rem; border-radius: 50px; font-size: 0.78rem;">
                                                ⚪ Standar
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            @else
                                @if($gejala->is_frequent)
                                    <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.3rem 0.65rem; border-radius: 50px; font-weight: 700; font-size: 0.78rem;">
                                        🔥 Sering Terjadi
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(148, 163, 184, 0.12); color: var(--text-muted); border: 1px solid var(--border); padding: 0.3rem 0.65rem; border-radius: 50px; font-size: 0.78rem;">
                                        ⚪ Standar
                                    </span>
                                @endif
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ panel_route('gejalas.edit', $gejala) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                        Edit
                                    </a>
                                    <form action="{{ panel_route('gejalas.destroy', $gejala) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" data-title="Hapus Gejala?" data-confirm="Gejala '{{ $gejala->nama_gejala }}' akan dihapus permanen." onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" style="text-align: center; color: var(--text-muted);">Belum ada data gejala.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $gejalas->links() }}
    </div>
</div>
@endsection


