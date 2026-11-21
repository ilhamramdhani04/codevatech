@extends('layouts.app')

@section('title', '500 — Kesalahan Server')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="text-center max-w-lg">
        {{-- Icon --}}
        <div class="mb-8">
            <svg class="mx-auto w-32 h-32 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>

        {{-- Error Code --}}
        <h1 class="text-8xl font-bold bg-gradient-to-r from-red-400 to-orange-400 bg-clip-text text-transparent mb-4">
            500
        </h1>

        {{-- Message --}}
        <h2 class="text-2xl font-semibold text-slate-200 mb-3">
            Terjadi Kesalahan Server
        </h2>
        <p class="text-slate-400 mb-8 leading-relaxed">
            Maaf, terjadi kesalahan internal pada server. Tim kami sudah diberitahu dan sedang memperbaiki masalah ini. Silakan coba lagi nanti.
        </p>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 shadow-lg shadow-blue-500/25">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
                </svg>
                Kembali ke Beranda
            </a>
            <button onclick="location.reload()"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-slate-600 text-slate-300 font-medium hover:bg-slate-800 hover:border-slate-500 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                </svg>
                Muat Ulang
            </button>
        </div>
    </div>
</div>
@endsection
