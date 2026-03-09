@extends('layouts.app')

@section('title', 'Pengguna — NexaDash')

@section('page_title', 'Pengguna')

@section('content')
<div x-data="{ 
          modalCreate: false, 
          modalEdit: false, 
          modalDelete: false,
          modalExport: false,
          exportType: 'all',
          currentUser: { id: '', name: '', email: '', role: '', status: '', bio: '' }
      }">
    <div class="animate-fade-up flex items-center justify-between mb-6 flex-wrap gap-3.5">
        <div>
            <h1 class="text-[22px] font-extrabold tracking-tight">Pengguna</h1>
            <p class="text-muted text-[14px] mt-1">Kelola pengguna platform Anda.</p>
        </div>
        <div class="flex gap-2.5">
            <button @click="modalExport = true" class="btn btn-secondary">
                <iconify-icon icon="solar:export-bold-duotone" width="18" height="18"></iconify-icon>
                Export Excel
            </button>
            <button @click="modalCreate = true" class="btn btn-primary">
                <iconify-icon icon="solar:user-plus-bold-duotone" width="18" height="18"></iconify-icon>
                Tambah Pengguna
            </button>
        </div>
    </div>

    @if(session('success'))
        <div
            class="mb-5 p-[12px_16px] bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-[14px] flex items-center gap-2.5">
            <iconify-icon icon="solar:check-circle-bold-duotone" width="20" height="20" class="text-emerald-500"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 p-[12px_16px] bg-rose-50 border border-rose-100 rounded-xl text-rose-700 text-[14px] flex items-center gap-2.5">
            <iconify-icon icon="solar:danger-circle-bold-duotone" width="20" height="20" class="text-rose-500"></iconify-icon>
            <div>
                <ul class="m-0 pl-3.5 leading-relaxed">
                    @foreach ($errors->all() as $error)
                        <li class="font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="animate-fade-up grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="card p-5 flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-[14px] flex items-center justify-center shrink-0 bg-[#eff6ff]">
                <iconify-icon icon="solar:users-group-rounded-linear" width="24" height="24" class="text-[#3b82f6]"></iconify-icon>
            </div>
            <div>
                <div class="text-[22px] font-extrabold">{{ $totalUsers ?? 0 }}</div>
                <div class="text-[13px] text-muted">Total Pengguna</div>
            </div>
        </div>
        <div class="card p-5 flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-[14px] flex items-center justify-center shrink-0 bg-[#f0fdf4]">
                <iconify-icon icon="solar:user-check-linear" width="24" height="24" class="text-[#10b981]"></iconify-icon>
            </div>
            <div>
                <div class="text-[22px] font-extrabold">{{ $activeUsers ?? 0 }}</div>
                <div class="text-[13px] text-muted">Pengguna Aktif</div>
            </div>
        </div>
        <div class="card p-5 flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-[14px] flex items-center justify-center shrink-0 bg-[#fff1f2]">
                <iconify-icon icon="solar:user-cross-linear" width="24" height="24" class="text-[#e11d48]"></iconify-icon>
            </div>
            <div>
                <div class="text-[22px] font-extrabold">{{ $inactiveUsers ?? 0 }}</div>
                <div class="text-[13px] text-muted">Tidak Aktif</div>
            </div>
        </div>
    </div>

    <div class="card animate-fade-up overflow-hidden">
        <!-- Filter Section -->
        <div class="p-[16px_20px] border-b border-border bg-surface">
            <form action="{{ route('users.index') }}" method="GET"
                class="flex justify-between items-center flex-wrap gap-4" id="filterForm">
                
                <div class="relative min-w-[180px] w-full max-w-[320px] flex-1">
                    <iconify-icon icon="solar:magnifer-linear" width="18" height="18" class="i-left text-muted-light"></iconify-icon>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-input pl-10! bg-bg border-border"
                        placeholder="Cari nama atau email..." oninput="this.form.submit()" />
                </div>
                
                <div class="flex flex-wrap gap-3 items-center">
                    <div class="relative min-w-[130px]">
                        <iconify-icon icon="solar:filter-linear" width="18" height="18" class="i-left text-muted-light"></iconify-icon>
                        <select name="role" class="form-input pl-10! cursor-pointer bg-bg border-border" onchange="this.form.submit()">
                            <option value="">Semua Peran</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="relative min-w-[130px]">
                        <iconify-icon icon="solar:info-circle-linear" width="18" height="18" class="i-left text-muted-light"></iconify-icon>
                        <select name="status" class="form-input pl-10! cursor-pointer bg-bg border-border" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto md:overflow-hidden overflow-scrolling-touch">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Peran</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="tbl-row">
                            <td>
                                <div class="flex items-center gap-4">
                                    <div class="w-[38px] h-[38px] rounded-full bg-brand-light text-brand text-[14px] font-bold uppercase flex items-center justify-center shrink-0 overflow-hidden">
                                        @if($user->foto_profile)
                                            <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="{{ $user->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            {{ substr($user->name, 0, 1) }}{{ substr(strrchr($user->name, ' '), 1, 1) ?: '' }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-[14px] font-bold tracking-tight text-text">{{ $user->name }}</div>
                                        <div class="text-[13px] text-muted mt-px">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1.5 {{ $user->role === 'admin' ? 'text-brand' : 'text-muted-light' }}">
                                    <iconify-icon icon="solar:shield-star-bold-duotone" width="16" height="16" class="shrink-0"></iconify-icon>
                                    <span class="text-[10px] font-bold uppercase">{{ $user->role }}</span>
                                </div>
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="inline-flex items-center gap-1.25 p-[2px_10px] rounded-full bg-[#ecfdf5] text-[#10b981] text-[10px] font-bold uppercase tracking-wide">
                                        <span class="w-1.25 h-1.25 bg-[#10b981] rounded-full"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.25 p-[2px_10px] rounded-full bg-[#f3f4f6] text-[#6b7280] text-[10px] font-bold uppercase tracking-wide">
                                        <span class="w-1.25 h-1.25 bg-[#6b7280] rounded-full"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-[13px] text-muted">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="flex justify-start gap-1.5">
                                    <div class="tip">
                                        <button class="w-9 h-9 rounded-xl flex items-center justify-center transition-all bg-[#fff7ed] text-[#f97316] hover:bg-[#ffedd5] shadow-sm border border-[#fdba74]/20"
                                            @click="currentUser = { id: '{{ $user->id }}', name: '{{ $user->name }}', email: '{{ $user->email }}', role: '{{ $user->role }}', status: '{{ $user->status }}', bio: '{{ $user->bio }}' }; modalEdit = true">
                                            <iconify-icon icon="solar:pen-new-square-bold" width="18" height="18"></iconify-icon>
                                        </button>
                                        <span class="tip-box">Edit Pengguna</span>
                                    </div>
                                    <div class="tip">
                                        <button class="w-9 h-9 rounded-xl flex items-center justify-center transition-all bg-[#fff1f2] text-[#e11d48] hover:bg-[#ffe4e6] shadow-sm border border-[#fda4af]/20"
                                            @click="currentUser = { id: '{{ $user->id }}', name: '{{ $user->name }}' }; modalDelete = true">
                                            <iconify-icon icon="solar:trash-bin-trash-bold" width="18" height="18"></iconify-icon>
                                        </button>
                                        <span class="tip-box">Hapus Pengguna</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-[40px_20px] text-center text-muted text-[14px]">Tidak
                                ada
                                pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-[14px_20px] border-t border-border">
            {{ $users->links('vendor.pagination.dash-simple') }}
        </div>
    </div>

    @include('users.modals')

</div>
@endsection