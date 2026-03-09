@extends('layouts.app')

@section('title', 'Beranda — NexaDash')

@section('page_title', 'Dashboard')

@section('content')
    @php
        $hour = date('H');
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Selamat pagi';
        } elseif ($hour >= 12 && $hour < 15) {
            $greeting = 'Selamat siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat sore';
        } else {
            $greeting = 'Selamat malam';
        }

        $user = auth()->user();
      @endphp

    <div class="animate-fade-up mb-6">
        <h1 class="text-[22px] font-extrabold text-text tracking-[-0.03em]">{{ $greeting }},
            {{ explode(' ', $user->name)[0] }} 👋
        </h1>
        <p class="text-muted text-[14px] mt-1">Kami senang melihat Anda kembali. Berikut ringkasan akun Anda hari ini.</p>
    </div>

    <div class="grid grid-cols-12 gap-5 mb-6">
        <div class="col-span-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                <div class="card p-5 flex items-center gap-4 shrink-0">
                    <div class="w-12 h-12 rounded-[18px] bg-rose-50 flex items-center justify-center shrink-0">
                        <iconify-icon icon="solar:calendar-bold-duotone" width="24" height="24"
                            class="text-rose-500"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[18px] font-extrabold text-text leading-tight">
                            {{ $user->created_at->diffForHumans(null, true) }}
                        </div>
                        <div class="text-[12px] text-muted font-medium">Lama Bergabung</div>
                    </div>
                </div>

                <div class="card p-5 flex items-center gap-4 shrink-0">
                    <div class="w-12 h-12 rounded-[18px] bg-amber-50 flex items-center justify-center shrink-0">
                        <iconify-icon icon="solar:history-bold-duotone" width="24" height="24"
                            class="text-amber-500"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[18px] font-extrabold text-text leading-tight">{{ $myActivities->count() }} Kali
                        </div>
                        <div class="text-[12px] text-muted font-medium">Total Aktivitas</div>
                    </div>
                </div>

                <div class="card p-5 flex items-center gap-4 shrink-0">
                    <div class="w-12 h-12 rounded-[18px] bg-emerald-50 flex items-center justify-center shrink-0">
                        <iconify-icon icon="solar:shield-check-bold-duotone" width="24" height="24"
                            class="text-emerald-500"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[18px] font-extrabold text-text leading-tight">Aktif</div>
                        <div class="text-[12px] text-muted font-medium">Status Akun</div>
                    </div>
                </div>

                <div class="card p-5 flex items-center gap-4 shrink-0">
                    <div class="w-12 h-12 rounded-[18px] bg-indigo-50 flex items-center justify-center shrink-0">
                        <iconify-icon icon="solar:medal-star-bold-duotone" width="24" height="24"
                            class="text-indigo-500"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[18px] font-extrabold text-text leading-tight">{{ ucfirst($user->role) }}</div>
                        <div class="text-[12px] text-muted font-medium">Level Akun</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-4">
            <div class="card p-6 h-full">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-[16px] font-bold text-text">Riwayat Aktivitas Anda</h3>
                </div>

                <div class="flex flex-col gap-5 border-l-2 border-dashed border-border/60 ml-3 pl-6">
                    @forelse($myActivities as $activity)
                        <div class="relative">
                            <!-- Dot in timeline -->
                            <div
                                class="absolute -left-[33px] top-1.5 w-3.5 h-3.5 bg-brand rounded-full border-4 border-white shadow-sm">
                            </div>

                            <div class="min-w-0">
                                <p class="text-[13.5px] text-text font-semibold leading-snug">
                                    {{ $activity->description }}
                                    @if($activity->log_name !== 'default')
                                        <span class="text-muted-light font-medium">pada</span>
                                        <span class="text-muted font-bold capitalize">{{ $activity->log_name }}</span>
                                    @endif
                                </p>
                                <div class="flex items-center gap-3 mt-1.5">
                                    <p class="text-[11px] text-muted-light flex items-center gap-1">
                                        <iconify-icon icon="solar:clock-circle-linear" width="12" height="12"></iconify-icon>
                                        {{ $activity->created_at->diffForHumans() }}
                                    </p>
                                    <span
                                        class="text-[10px] px-1.5 py-0.5 bg-bg border border-border rounded text-muted font-bold uppercase tracking-wider">
                                        {{ $activity->event }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 text-center -ml-6 border-0">
                            <iconify-icon icon="solar:ghost-linear" width="40" height="40"
                                class="text-border mb-3"></iconify-icon>
                            <p class="text-[13px] text-muted-light">Belum ada riwayat aktivitas terbaru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection