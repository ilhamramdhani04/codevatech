@extends('layouts.app')

@section('title', '503 — Sedang Maintenance')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="text-center max-w-lg">
        {{-- Icon --}}
        <div class="mb-8">
            <svg class="mx-auto w-32 h-32 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384-3.19A1.5 1.5 0 014.5 10.78V6.22a1.5 1.5 0 011.536-1.2l5.384 3.19a1.5 1.5 0 01.536 1.2v4.56a1.5 1.5 0 01-.536 1.2zm6.72-3.19l-5.384 3.19a1.5 1.5 0 01-.536-1.2V9.41a1.5 1.5 0 01.536-1.2l5.384-3.19A1.5 1.5 0 0119.5 6.22v4.56a1.5 1.5 0 01-1.536 1.2z" />
            </svg>
        </div>

        {{-- Error Code --}}
        <h1 class="text-8xl font-bold bg-gradient-to-r from-amber-400 to-yellow-400 bg-clip-text text-transparent mb-4">
            503
        </h1>

        {{-- Message --}}
        <h2 class="text-2xl font-semibold text-slate-200 mb-3">
            Sedang Dalam Perbaikan
        </h2>
        <p class="text-slate-400 mb-8 leading-relaxed">
            Kami sedang melakukan pemeliharaan sistem untuk meningkatkan layanan. Mohon tunggu beberapa saat, sistem akan segera aktif kembali.
        </p>

        {{-- Progress indicator --}}
        <div class="mb-8">
            <div class="w-64 mx-auto h-2 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-amber-400 to-yellow-400 rounded-full animate-pulse" style="width: 60%"></div>
            </div>
            <p class="text-slate-500 text-sm mt-3">Proses maintenance sedang berlangsung...</p>
        </div>

        {{-- Action --}}
        <button onclick="location.reload()"
                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-amber-600 to-yellow-600 text-white font-medium hover:from-amber-700 hover:to-yellow-700 transition-all duration-300 shadow-lg shadow-amber-500/25">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
            </svg>
            Coba Lagi
        </button>
    </div>
</div>
@endsection
