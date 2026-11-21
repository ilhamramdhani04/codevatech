@extends('layouts.admin')

@section('title', 'Detail Rule — CODEVA TECH')

@section('content')
<div class="header-title">
    <div>
        <h1>Detail Rule <span style="color: var(--primary);">{{ $rule->kode_rule }}</span></h1>
        <p style="color: var(--text-muted);">Formulasi logika inferensi Forward Chaining.</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ panel_route('rules.edit', $rule) }}" class="btn btn-primary">Edit Rule</a>
        <a href="{{ panel_route('rules.index') }}" class="btn btn-outline" style="color: var(--text-muted);">← Kembali</a>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 1rem;">Logika Inferensi</h3>
    <div style="background: rgba(15,23,42,0.8); padding: 1.5rem; border-radius: 0.75rem; border: 1px solid var(--border); font-family: monospace; font-size: 1.1rem; line-height: 1.8;">
        <span style="color: var(--warning); font-weight: bold;">IF</span>
        <div style="padding-left: 1.5rem; margin: 0.5rem 0;">
            @foreach($rule->ruleGejala as $index => $rg)
                <div>
                    @if($rg->is_negated)
                        <span style="color: var(--danger); font-weight: bold;">NOT</span>
                    @endif
                    <span style="color: var(--primary); font-weight: bold;">{{ $rg->gejala->kode_gejala }}</span>
                    <span style="color: var(--text-muted);">({{ $rg->gejala->nama_gejala }})</span>
                    @if(!$loop->last)
                        <span style="color: var(--accent); font-weight: bold;">AND</span>
                    @endif
                </div>
            @endforeach
        </div>
        <span style="color: var(--success); font-weight: bold;">THEN</span>
        <div style="padding-left: 1.5rem; margin-top: 0.5rem;">
            <strong style="color: #f8fafc;">[{{ $rule->kerusakan->kode_kerusakan }}] {{ $rule->kerusakan->nama_kerusakan }}</strong>
        </div>
    </div>
</div>

@if($rule->keterangan)
    <div class="card">
        <h4>Catatan Keterangan</h4>
        <p style="color: var(--text-muted); margin-top: 0.5rem;">{{ $rule->keterangan }}</p>
    </div>
@endif
@endsection
