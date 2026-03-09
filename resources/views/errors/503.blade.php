@extends('layouts.auth')

@section('title', '503 Layanan Tidak Tersedia')

@section('content')
    <div class="text-center animate-fade-up">
        <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
            <iconify-icon icon="solar:settings-bold-duotone" width="44" height="44"
                class="animate-spin duration-[3s]"></iconify-icon>
        </div>

        <h1 class="text-2xl font-extrabold text-text tracking-tight mb-2">503 - Maintenance Mode</h1>
        <p class="text-[14.5px] text-muted leading-relaxed mb-8">Kami sedang melakukan pemeliharaan sistem rutin demi
            meningkatkan pengalaman Anda. Kami akan segera kembali!</p>

        <button onclick="window.location.reload()"
            class="btn btn-primary w-full h-12 justify-center text-[15px] font-bold shadow-lg shadow-brand/10 transition-all hover:-translate-y-0.5">
            <iconify-icon icon="solar:refresh-linear" width="18" height="18"></iconify-icon>
            Coba Muat Ulang
        </button>
    </div>
@endsection