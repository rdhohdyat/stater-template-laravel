<div class="fixed inset-0 z-77 bg-[#11182766] backdrop-blur-[1px] md:hidden" x-show="mobileOpen" x-transition.opacity
    @click="mobileOpen = false" x-cloak></div>
<aside
    class="fixed top-3 bottom-3 flex flex-col bg-surface border border-border shadow-md rounded-[24px] z-100 transition-[width,left] duration-300 ease-in-out overflow-visible"
    :class="[collapsed ? 'w-[68px]' : 'w-sidebar', mobileOpen ? 'left-3' : 'left-[-300px] md:left-4']">
    <div class="p-[22px_18px_18px] border-b border-border overflow-hidden">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-brand-light rounded-[10px] flex items-center justify-center shrink-0">
                <iconify-icon icon="solar:box-minimalistic-bold-duotone" width="22" height="22"
                    class="text-brand"></iconify-icon>
            </div>
            <div class="logo-text" :class="collapsed && 'hidden'">
                <div class="text-[15px] font-extrabold text-text tracking-tight">NexaDash</div>
                <div class="text-[11px] text-muted-light">Starter Kit v2.0</div>
            </div>
        </div>
    </div>
    <nav class="flex-1 p-[12px_10px]" :class="collapsed ? 'overflow-visible' : 'overflow-y-auto overflow-x-hidden'">
        <span class="text-[10px] font-bold tracking-widest text-muted-light uppercase p-[18px_14px_8px] block"
            :class="collapsed && 'hidden'">Menu Utama</span>

        <a class="flex items-center gap-2.5 p-[9px_12px] rounded-xl cursor-pointer transition-all duration-200 no-underline text-[13.5px] font-semibold relative mb-1.5 hover:bg-brand-light hover:text-brand {{ request()->is('dashboard') ? 'bg-brand-light text-brand' : 'text-muted' }}"
            href="{{ url('dashboard') }}">
            <iconify-icon icon="solar:home-smile-linear" class="w-[18px] h-[18px] shrink-0" width="20"
                height="20"></iconify-icon>
            <span class="nav-label" :class="collapsed && 'hidden'">Dashboard</span>
        </a>

        @if(auth()->user()->role === 'admin')
            <a class="flex items-center gap-2.5 p-[9px_12px] rounded-xl cursor-pointer transition-all duration-200 no-underline text-[13.5px] font-semibold relative mb-1.5 hover:bg-brand-light hover:text-brand {{ request()->is('users*') ? 'bg-brand-light text-brand' : 'text-muted' }}"
                href="{{ url('users') }}">
                <iconify-icon icon="solar:users-group-rounded-linear" class="w-[18px] h-[18px] shrink-0" width="20"
                    height="20"></iconify-icon>
                <span class="nav-label" :class="collapsed && 'hidden'">Pengguna</span>
            </a>
        @endif

        <a class="flex items-center gap-2.5 p-[9px_12px] rounded-xl cursor-pointer transition-all duration-200 no-underline text-[13.5px] font-semibold relative mb-1.5 hover:bg-brand-light hover:text-brand {{ request()->is('history*') ? 'bg-brand-light text-brand' : 'text-muted' }}"
            href="{{ route('activitylogs.history') }}">
            <iconify-icon icon="solar:notes-linear" class="w-[18px] h-[18px] shrink-0" width="20"
                height="20"></iconify-icon>
            <span class="nav-label" :class="collapsed && 'hidden'">History</span>
        </a>



        @if(auth()->user()->role === 'admin')
            <span class="text-[10px] font-bold tracking-widest text-muted-light uppercase p-[18px_14px_8px] block mt-1"
                :class="collapsed && 'hidden'">Sistem</span>

            <a class="flex items-center gap-2.5 p-[9px_12px] rounded-xl cursor-pointer transition-all duration-200 no-underline text-[13.5px] font-semibold relative mb-1.5 hover:bg-brand-light hover:text-brand {{ request()->is('activity-logs*') ? 'bg-brand-light text-brand' : 'text-muted' }}"
                href="{{ route('activitylogs.index') }}">
                <iconify-icon icon="solar:history-bold-duotone" class="w-[18px] h-[18px] shrink-0" width="20"
                    height="20"></iconify-icon>
                <span class="nav-label" :class="collapsed && 'hidden'">Log Sistem</span>
            </a>

            <a class="flex items-center gap-2.5 p-[9px_12px] rounded-xl cursor-pointer transition-all duration-200 no-underline text-[13.5px] font-semibold relative mb-1.5 hover:bg-brand-light hover:text-brand {{ request()->is('backups*') ? 'bg-brand-light text-brand' : 'text-muted' }}"
                href="{{ route('backups.index') }}">
                <iconify-icon icon="solar:database-linear" class="w-[18px] h-[18px] shrink-0" width="20"
                    height="20"></iconify-icon>
                <span class="nav-label" :class="collapsed && 'hidden'">Backup Database</span>
            </a>
            <a class="flex items-center gap-2.5 p-[9px_12px] rounded-xl cursor-pointer transition-all duration-200 no-underline text-[13.5px] font-semibold relative mb-1.5 hover:bg-brand-light text-muted hover:text-brand"
                href="">
                <iconify-icon icon="solar:layers-minimalistic-linear" class="w-[18px] h-[18px] shrink-0" width="20"
                    height="20"></iconify-icon>
                <span class="nav-label" :class="collapsed && 'hidden'">Komponen UI</span>
            </a>
        @endif

        <span class="text-[10px] font-bold tracking-widest text-muted-light uppercase p-[18px_14px_8px] block mt-1"
            :class="collapsed && 'hidden'">Akun</span>

        <a class="flex items-center gap-2.5 p-[9px_12px] rounded-xl cursor-pointer transition-all duration-200 no-underline text-[13.5px] font-semibold relative mb-1.5 hover:bg-brand-light hover:text-brand {{ request()->is('settings*') ? 'bg-brand-light text-brand' : 'text-muted' }}"
            href="{{ url('settings') }}">
            <iconify-icon icon="solar:settings-linear" class="w-[18px] h-[18px] shrink-0" width="20"
                height="20"></iconify-icon>
            <span class="nav-label" :class="collapsed && 'hidden'">Pengaturan</span>
        </a>
    </nav>

    <div class="p-[14px_18px] border-t border-border overflow-hidden mt-auto">
        <div class="flex items-center gap-2.5">
            <div
                class="w-[34px] h-[34px] bg-brand-light text-brand text-[12px] font-bold shrink-0 flex items-center justify-center rounded-full overflow-hidden">
                @if(auth()->user()->foto_profile)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Profile"
                        class="w-full h-full object-cover">
                @else
                    {{ substr(auth()->user()->name, 0, 1) }}{{ substr(strrchr(auth()->user()->name, ' '), 1, 1) ?: '' }}
                @endif
            </div>
            <div class="flex-1 min-w-0" :class="collapsed && 'hidden'">
                <div class="text-[13px] font-bold text-text truncate">{{ auth()->user()->name }}</div>
                <div class="text-[11px] text-muted-light truncate">{{ auth()->user()->email }}</div>
            </div>
            <a href="{{ url('settings') }}" class="btn btn-icon btn-secondary p-1 border-0 shadow-none hover:bg-bg"
                :class="collapsed && 'hidden'" title="Pengaturan">
                <iconify-icon icon="solar:settings-outline" width="18" height="18"></iconify-icon>
            </a>
        </div>
    </div>
</aside>