@extends('layouts.app')

@section('title', '403 — Akses Ditolak')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="text-center max-w-lg">
        {{-- Icon --}}
        <div class="mb-8">
            <svg class="mx-auto w-32 h-32 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
        </div>

        {{-- Error Code --}}
        <h1 class="text-8xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-4">
            403
        </h1>

        {{-- Message --}}
        <h2 class="text-2xl font-semibold text-slate-200 mb-3">
            Akses Ditolak
        </h2>
        <p class="text-slate-400 mb-8 leading-relaxed">
            Anda tidak memiliki izin untuk mengakses halaman ini. Jika ini adalah kesalahan, silakan hubungi administrator.
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
            <a href="{{ route('admin.login') }}"
               class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-slate-600 text-slate-300 font-medium hover:bg-slate-800 hover:border-slate-500 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Login Admin
            </a>
        </div>
    </div>
</div>
@endsection
