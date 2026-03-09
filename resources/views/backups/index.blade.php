@extends('layouts.app')

@section('page_title', 'Database Backup')

@section('content')
    <div class="animate-fade-up mb-6">
        <h1 class="text-[22px] font-extrabold tracking-tight">Database Backup</h1>
        <p class="text-muted text-[14px] mt-1">Cadangkan data sistem Anda untuk keamanan.</p>
    </div>

    @if(session('success'))
        <div
            class="mb-5 p-[12px_16px] bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-[14px] flex items-center gap-2.5">
            <iconify-icon icon="solar:check-circle-bold-duotone" width="20" height="20" class="text-emerald-500"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div
            class="mb-5 p-[12px_16px] bg-rose-50 border border-rose-100 rounded-xl text-rose-700 text-[14px] flex items-center gap-2.5">
            <iconify-icon icon="solar:danger-circle-bold-duotone" width="20" height="20" class="text-rose-500"></iconify-icon>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-up">
        <!-- Backup Action Card -->
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <div
                    class="w-14 h-14 bg-brand-light text-brand rounded-2xl flex items-center justify-center mb-5 shadow-sm">
                    <iconify-icon icon="solar:database-bold-duotone" width="30" height="30"></iconify-icon>
                </div>
                <h3 class="text-[17px] font-bold mb-2">Buat Cadangan Baru</h3>
                <p class="text-[14px] text-muted leading-relaxed mb-6">
                    Proses ini akan mengekspor seluruh struktur dan data database Anda menjadi file .zip yang aman secara
                    instan.
                </p>
            </div>

            <form action="{{ route('backups.run') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary w-full justify-center py-3 rounded-2xl">
                    <iconify-icon icon="solar:shield-up-bold-duotone" width="20" height="20"></iconify-icon>
                    Jalankan Backup Sekarang
                </button>
            </form>
        </div>

        <!-- Download Latest Card -->
        <div class="card p-6 flex flex-col justify-between border-dashed bg-bg/20">
            <div>
                <div
                    class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-5 shadow-sm">
                    <iconify-icon icon="solar:download-square-bold-duotone" width="30" height="30"></iconify-icon>
                </div>
                <h3 class="text-[17px] font-bold mb-2">Unduh File Terakhir</h3>
                <p class="text-[14px] text-muted leading-relaxed mb-6">
                    Dapatkan file backup terbaru yang tersimpan di server. Sangat disarankan untuk menyimpan file ini di
                    penyimpanan lokal Anda.
                </p>
            </div>

            <a href="{{ route('backups.download') }}"
                class="btn btn-secondary w-full justify-center py-3 rounded-2xl no-underline">
                <iconify-icon icon="solar:cloud-download-bold-duotone" width="20" height="20"></iconify-icon>
                Unduh Cadangan (.zip)
            </a>
        </div>
    </div>

    <!-- Security Information -->
    <div class="mt-8 p-6 bg-amber-50 rounded-[24px] border border-amber-100 flex gap-4 animate-fade-up">
        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center shrink-0">
            <iconify-icon icon="solar:shield-warning-bold-duotone" width="20" height="20"></iconify-icon>
        </div>
        <div>
            <h4 class="text-[14px] font-bold text-amber-900 mb-1.5">Informasi Keamanan Penting</h4>
            <p class="text-[13px] text-amber-800 leading-relaxed opacity-80">
                File backup berisi data sensitif seluruh sistem. Pastikan hanya personel berwenang yang dapat mengakses
                halaman ini. Selalu hapus file backup lama secara berkala untuk menjaga kapasitas server.
            </p>
        </div>
    </div>
@endsection