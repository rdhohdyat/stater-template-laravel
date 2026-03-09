@extends('layouts.auth')

@section('title', '500 Kesalahan Server')

@section('content')
    <div class="text-center animate-fade-up">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
            <iconify-icon icon="solar:danger-bold-duotone" width="44" height="44"></iconify-icon>
        </div>

        <h1 class="text-2xl font-extrabold text-text tracking-tight mb-2">503 - Maintenance</h1>
        <p class="text-[14.5px] text-muted leading-relaxed mb-8">Maaf, terjadi kesalahan internal pada server kami. Mohon
            coba lagi beberapa saat lagi.</p>

        <a href="{{ url('/') }}"
            class="btn btn-primary w-full h-12 justify-center text-[15px] font-bold shadow-lg shadow-brand/10 transition-all hover:-translate-y-0.5">
            <iconify-icon icon="solar:refresh-linear" width="18" height="18"></iconify-icon>
            Coba Segarkan Halaman
        </a>
    </div>
@endsection