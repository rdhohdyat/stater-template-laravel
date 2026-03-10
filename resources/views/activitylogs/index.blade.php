@extends('layouts.app')

@section('title', 'Log Sistem — NexaDash')
@section('page_title', 'Log Sistem')

@section('content')
    <div x-data="{ 
                        showModal: false, 
                        selectedLog: null, 
                        logs: @js($logs->items()),
                        getLogDetail(id) {
                            this.selectedLog = this.logs.find(l => l.id == id);
                            this.showModal = true;
                        },
                        formatDate(dateStr) {
                            const date = new Date(dateStr);
                            return date.toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' });
                        }
                    }">
        <div class="animate-fade-up mb-6">
            <h1 class="text-[22px] font-extrabold tracking-tight">Log Aktivitas Sistem</h1>
            <p class="text-muted text-[14px] mt-1">Pantau segala aktivitas dan perubahan yang terjadi di seluruh sistem.</p>
        </div>

        <!-- Filter Kontrol -->
        <div
            class="animate-fade-up card p-[16px_20px] mb-6 flex justify-between items-center flex-wrap gap-4 border-border/60">
            <form action="{{ route('activitylogs.index') }}" method="GET"
                class="flex items-center gap-3 w-full lg:w-auto flex-wrap sm:flex-nowrap">
                <div class="relative w-full sm:w-[260px]">
                    <iconify-icon icon="solar:magnifer-linear" width="18" height="18"
                        class="i-left text-muted-light"></iconify-icon>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-input pl-10! bg-bg border-border rounded-xl text-[13px]"
                        placeholder="Cari pelaku atau aksi..." onchange="this.form.submit()" />
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="form-input bg-bg border-border rounded-xl text-[12px] py-2" onchange="this.form.submit()" />
                    <span class="text-muted">/</span>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="form-input bg-bg border-border rounded-xl text-[12px] py-2" onchange="this.form.submit()" />
                </div>

                @if(request('search') || request('start_date') || request('end_date'))
                   <a href="{{ route('activitylogs.index') }}" class="btn btn-secondary p-2.5 rounded-xl shadow-sm">
                        <iconify-icon icon="solar:refresh-linear" width="18" height="18"></iconify-icon>
                    </a>
                @endif
            </form>

            <div class="flex items-center gap-3">
                <form action="{{ route('activitylogs.index') }}" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="sort" class="form-input bg-bg border-border rounded-xl text-[13px] cursor-pointer"
                        onchange="this.form.submit()">
                        <option value="desc" {{ request('sort') !== 'asc' ? 'selected' : '' }}>Terbaru</option>
                        <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="animate-fade-up">
            @php
                $groupedLogs = $logs->groupBy(function ($log) {
                    if ($log->created_at->isToday())
                        return 'Hari Ini';
                    if ($log->created_at->isYesterday())
                        return 'Kemarin';
                    return $log->created_at->translatedFormat('d F Y');
                });
            @endphp

            <div class="flex flex-col gap-6">
                @forelse($groupedLogs as $date => $dayLogs)
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-3 px-1">
                            <span class="text-[11px] font-extrabold text-muted uppercase tracking-widest">{{ $date }}</span>
                            <div class="h-px flex-1 bg-border/40"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($dayLogs as $log)
                                @php
                                    $event = $log->event;
                                    $cfg = match ($event) {
                                        'login' => ['icon' => 'solar:login-3-bold-duotone', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
                                        'logout' => ['icon' => 'solar:logout-3-bold-duotone', 'color' => 'text-slate-400', 'bg' => 'bg-slate-50'],
                                        'created' => ['icon' => 'solar:add-circle-bold-duotone', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
                                        'deleted' => ['icon' => 'solar:trash-bin-trash-bold-duotone', 'color' => 'text-rose-500', 'bg' => 'bg-rose-50'],
                                        default => ['icon' => 'solar:pen-new-square-bold-duotone', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50']
                                    };
                                @endphp
                                <div @click="getLogDetail({{ $log->id }})"
                                    class="card p-4 flex items-center gap-4 cursor-pointer transition-all duration-200 group">
                                    <div
                                        class="w-11 h-11 rounded-2xl {{ $cfg['bg'] }} {{ $cfg['color'] }} flex items-center justify-center shrink-0 border border-black/5">
                                        <iconify-icon icon="{{ $cfg['icon'] }}" width="22" height="22"></iconify-icon>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2 mb-1">
                                            <h4 class="text-[13.5px] font-bold text-text truncate">
                                                @if($event === 'login') Login
                                                @elseif($event === 'logout') Logout
                                                @elseif($event === 'created') Ditambahkan
                                                @elseif($event === 'deleted') Dihapus
                                                @else Diperbarui
                                                @endif
                                                <span class="text-muted-light font-normal">| {{ $log->log_name }}</span>
                                            </h4>
                                            <span
                                                class="text-[11px] font-medium text-muted shrink-0">{{ $log->created_at->format('H:i') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[11.5px] font-semibold text-muted-light truncate">
                                                {{ $log->causer ? explode(' ', $log->causer->name)[0] : 'Sistem' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        <iconify-icon icon="solar:alt-arrow-right-linear" width="18" height="18"
                                            class="text-muted-light"></iconify-icon>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="card py-20 text-center">
                        <div
                            class="w-16 h-16 bg-bg rounded-2xl flex items-center justify-center mx-auto mb-4 border border-border border-dashed">
                            <iconify-icon icon="solar:history-bold-duotone" width="32" height="32"
                                class="text-border"></iconify-icon>
                        </div>
                        <p class="text-muted text-[13px] font-medium">Belum ada aktivitas sistem yang tercatat.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $logs->links('vendor.pagination.dash-simple') }}
            </div>
        </div>

        <!-- Detail Modal Admin -->
        <template x-teleport="body">
            <template x-if="showModal">
                <div class="modal-overlay" @click.self="showModal = false" x-cloak
                    x-init="document.body.style.overflow = 'hidden'; return () => document.body.style.overflow = ''"
                    @unload.window="document.body.style.overflow = ''">
                    <div class="modal-box animate-fade-up max-w-[500px] w-full p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-[17px] font-extrabold tracking-tight">Detail Aktivitas Sistem</h3>
                                <p class="text-[12px] text-muted">Informasi teknis rekaman aktivitas.</p>
                            </div>
                            <button @click="showModal = false" class="btn btn-icon btn-secondary -mr-2">
                                <iconify-icon icon="lucide:x" width="20" height="20"></iconify-icon>
                            </button>
                        </div>

                        <template x-if="selectedLog">
                            <div class="flex flex-col gap-5">
                                <div class="bg-bg rounded-2xl p-4 border border-border/50">
                                    <div class="grid grid-cols-2 gap-y-4 text-[13px]">
                                        <div>
                                            <div class="text-muted text-[11px] font-bold uppercase tracking-wider mb-1">
                                                Pelaku (Causer)</div>
                                            <div class="font-bold text-text"
                                                x-text="selectedLog.causer ? selectedLog.causer.name : 'Sistem'"></div>
                                        </div>
                                        <div>
                                            <div class="text-muted text-[11px] font-bold uppercase tracking-wider mb-1">Aksi
                                                & Entitas</div>
                                            <div class="font-bold text-text capitalize"
                                                x-text="selectedLog.event + ' | ' + selectedLog.log_name"></div>
                                        </div>
                                        <div>
                                            <div class="text-muted text-[11px] font-bold uppercase tracking-wider mb-1">
                                                Waktu</div>
                                            <div class="font-bold text-text" x-text="formatDate(selectedLog.created_at)">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-muted text-[11px] font-bold uppercase tracking-wider mb-1">
                                                Alamat IP</div>
                                            <div class="font-bold text-text"
                                                x-text="selectedLog.properties?.ip_address || 'N/A'"></div>
                                        </div>
                                        <div class="col-span-2">
                                            <div class="text-muted text-[11px] font-bold uppercase tracking-wider mb-1">User
                                                Agent</div>
                                            <div class="text-[11.5px] text-muted-light break-all leading-normal"
                                                x-text="selectedLog.properties?.user_agent || 'N/A'"></div>
                                        </div>
                                    </div>
                                </div>

                                <template
                                    x-if="selectedLog.properties && selectedLog.properties.attributes && Object.keys(selectedLog.properties.attributes).length > 0">
                                    <div>
                                        <div class="text-muted text-[11px] font-bold uppercase tracking-wider mb-3 px-1">
                                            Perubahan Atribut</div>
                                        <div
                                            class="flex flex-col gap-2.5 max-h-[250px] overflow-y-auto pr-1 custom-scrollbar">
                                            <template x-for="(value, key) in selectedLog.properties.attributes" :key="key">
                                                <div class="p-3 bg-white border border-border rounded-xl">
                                                    <div class="text-[11px] font-bold text-muted-light mb-1.5 uppercase tracking-tighter"
                                                        x-text="key"></div>
                                                    <div class="flex flex-wrap items-center gap-2 text-[12.5px]">
                                                        <template
                                                            x-if="selectedLog.properties.old && selectedLog.properties.old[key] !== undefined">
                                                            <span class="text-muted line-through"
                                                                x-text="selectedLog.properties.old[key]"></span>
                                                        </template>
                                                        <template
                                                            x-if="selectedLog.properties.old && selectedLog.properties.old[key] !== undefined">
                                                            <iconify-icon icon="solar:alt-arrow-right-linear"
                                                                class="text-muted-light"></iconify-icon>
                                                        </template>
                                                        <span class="text-emerald-600 font-bold" x-text="value"></span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <div class="mt-8">
                            <button @click="showModal = false"
                                class="btn btn-secondary w-full justify-center py-3 rounded-xl font-bold">
                                Tutup Rincian
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </template>
    </div>
@endsection