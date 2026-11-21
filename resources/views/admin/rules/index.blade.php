@extends('layouts.admin')

@section('title', 'Rule Knowledge Base — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Rules (Knowledge Base Forward Chaining)</h1>
        <p style="color: var(--text-muted);">Aturan IF (gejala) THEN (kerusakan).</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ panel_route('rules.create') }}" class="btn btn-primary">
            + Tambah Rule Baru
        </a>
    @else
        <span style="font-size: 0.85rem; background: rgba(148, 163, 184, 0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.3);">
            👁️ Referensi Teknisi (Read-Only)
        </span>
    @endif
</div>

<div class="card">
    <form action="{{ panel_route('rules.index') }}" method="GET" style="margin-bottom: 1.5rem; display: flex; gap: 1rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari kode rule / nama kerusakan..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
        @if(request()->filled('search'))
            <a href="{{ panel_route('rules.index') }}" class="btn btn-outline" style="color: var(--text-muted);">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Rule</th>
                    <th>Hasil Kerusakan (THEN)</th>
                    <th>Jumlah Gejala (IF)</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rules as $rule)
                    <tr>
                        <td>{{ $rules->firstItem() + $loop->index }}</td>
                        <td><strong style="color: var(--primary);">{{ $rule->kode_rule }}</strong></td>
                        <td>
                            <strong>[{{ $rule->kerusakan->kode_kerusakan ?? '-' }}]</strong>
                            {{ $rule->kerusakan->nama_kerusakan ?? 'Kerusakan Dihapus' }}
                        </td>
                        <td>{{ $rule->ruleGejala->count() }} Gejala</td>
                        <td>{{ $rule->keterangan ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ panel_route('rules.show', $rule) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                    Detail
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ panel_route('rules.edit', $rule) }}" class="btn btn-secondary" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;">
                                        Edit
                                    </a>
                                    <form action="{{ panel_route('rules.destroy', $rule) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" style="padding: 0.3rem 0.75rem; font-size: 0.8rem;" data-title="Hapus Rule?" data-confirm="Rule inference ini akan dihapus permanen." onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data rule.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $rules->links() }}
    </div>
</div>
@endsection


