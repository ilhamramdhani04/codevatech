@extends('layouts.admin')

@section('title', 'Detail Kerusakan — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1><span style="color: var(--primary);">[{{ $kerusakan->kode_kerusakan }}]</span> {{ $kerusakan->nama_kerusakan }}</h1>
        <p style="color: var(--text-muted);">
            Kategori:
            <span class="badge {{ strtolower($kerusakan->kategori->nama_kategori ?? '') === 'software' ? 'badge-software' : 'badge-hardware' }}">
                {{ $kerusakan->kategori->nama_kategori ?? '-' }}
            </span>
        </p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ panel_route('kerusakans.edit', $kerusakan) }}" class="btn btn-secondary">Edit Master</a>
        <a href="{{ panel_route('kerusakans.index') }}" class="btn btn-outline" style="color: var(--text-muted);">← Kembali</a>
    </div>
</div>

<!-- Penyebab Section -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>⚠️ Daftar Penyebab</h3>
        <a href="{{ panel_route('kerusakans.penyebabs.create', $kerusakan) }}" class="btn btn-primary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">
            + Tambah Penyebab
        </a>
    </div>

    @if($kerusakan->penyebabs->isEmpty())
        <p style="color: var(--text-muted);">Belum ada data penyebab.</p>
    @else
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
            @foreach($kerusakan->penyebabs as $penyebab)
                <li style="display: flex; justify-content: space-between; align-items: center; background: rgba(15,23,42,0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                    <span>• {{ $penyebab->deskripsi }}</span>
                    <div style="display: flex; gap: 0.4rem;">
                        <a href="{{ panel_route('penyebabs.edit', [$kerusakan, $penyebab]) }}" class="btn btn-secondary" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">Edit</a>
                        <form action="{{ panel_route('penyebabs.destroy', [$kerusakan, $penyebab]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;" data-title="Hapus Penyebab?" data-confirm="Penyebab ini akan dihapus permanen." onclick="confirmDelete(this)">Hapus</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<!-- Solusi Section -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>💡 Daftar Solusi & Rekomendasi Bertahap</h3>
        <a href="{{ panel_route('kerusakans.solusis.create', $kerusakan) }}" class="btn btn-primary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">
            + Tambah Solusi
        </a>
    </div>

    @if($kerusakan->solusis->isEmpty())
        <p style="color: var(--text-muted);">Belum ada data solusi.</p>
    @else
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
            @foreach($kerusakan->solusis as $solusi)
                <li style="display: flex; justify-content: space-between; align-items: center; background: rgba(15,23,42,0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                    <div>
                        <strong style="color: var(--primary);">#{{ $solusi->urutan }}</strong> {{ $solusi->deskripsi }}
                    </div>
                    <div style="display: flex; gap: 0.4rem;">
                        <a href="{{ panel_route('solusis.edit', [$kerusakan, $solusi]) }}" class="btn btn-secondary" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">Edit</a>
                        <form action="{{ panel_route('solusis.destroy', [$kerusakan, $solusi]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;" data-title="Hapus Solusi?" data-confirm="Solusi ini akan dihapus permanen." onclick="confirmDelete(this)">Hapus</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<!-- Rule Trigger Section -->
<div class="card">
    <h3>⚡ Rule yang Menghasilkan Kerusakan Ini</h3>
    @if($kerusakan->rules->isEmpty())
        <p style="color: var(--text-muted); margin-top: 0.5rem;">Belum ada rule yang mengarah ke kerusakan ini.</p>
    @else
        <div class="table-responsive" style="margin-top: 0.75rem;">
            <table>
                <thead>
                    <tr>
                        <th>Kode Rule</th>
                        <th>Kondisi Gejala (IF)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kerusakan->rules as $rule)
                        <tr>
                            <td>
                                <a href="{{ panel_route('rules.edit', $rule) }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">
                                    {{ $rule->kode_rule }}
                                </a>
                            </td>
                            <td>
                                @foreach($rule->ruleGejala as $rg)
                                    <span style="font-size: 0.85rem; padding: 0.2rem 0.5rem; border-radius: 0.25rem; background: rgba(255,255,255,0.05); margin-right: 0.25rem;">
                                        @if($rg->is_negated) <strong style="color: var(--danger);">NOT</strong> @endif
                                        {{ $rg->gejala->kode_gejala }} ({{ $rg->gejala->nama_gejala }})
                                    </span>
                                @endforeach
                            </td>
                            <td>{{ $rule->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection


