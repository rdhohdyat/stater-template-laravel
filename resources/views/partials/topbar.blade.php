<div class="bg-surface rounded-2xl p-[10px_16px] flex items-center gap-3 border border-border shadow-sm mb-4">
  <button @click="window.innerWidth <= 768 ? mobileOpen = !mobileOpen : collapsed = !collapsed"
    class="btn btn-icon btn-secondary shadow-none border-0 hover:bg-bg rounded-[10px]">
    <iconify-icon icon="solar:hamburger-menu-outline" width="20" height="20"></iconify-icon>
  </button>
  <div class="flex items-center gap-1.5 text-[13.5px] text-muted md:flex">
    <a class="text-text no-underline font-medium hover:text-brand" href="{{ url('dashboard') }}">Beranda</a>
    <iconify-icon icon="solar:alt-arrow-right-linear" width="14" height="14" class="text-muted-light mt-0.5"></iconify-icon>
    <span class="text-text font-bold tracking-tight">@yield('page_title', 'Dasbor')</span>
  </div>

  <div class="flex items-center gap-2.5 ml-auto">
    <!-- Theme Toggle -->
    <button @click="darkMode = !darkMode" class="btn btn-icon btn-secondary shadow-none border-0 hover:bg-bg rounded-[10px]" title="Ganti Tema">
      <iconify-icon x-show="!darkMode" icon="solar:moon-linear" width="20" height="20"></iconify-icon>
      <iconify-icon x-show="darkMode" icon="solar:sun-2-linear" width="20" height="20" class="text-warning"></iconify-icon>
    </button>

    <!-- Notifications -->
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open" class="btn btn-icon btn-secondary relative shadow-none border-0 hover:bg-bg rounded-[10px]">
        <iconify-icon icon="solar:bell-bing-linear" width="22" height="22"></iconify-icon>
        <span class="w-2 h-2 bg-red-500 rounded-full absolute top-2 right-2 border-2 border-surface"></span>
      </button>
      <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute right-0 top-[calc(100%+8px)] bg-surface rounded-[24px] shadow-lg border border-border p-1.5 z-55 w-[300px]" x-cloak>
        <div class="p-[12px_16px] text-[14px] font-extrabold tracking-tight">Notifikasi</div>
        <div class="h-px bg-border mx-2"></div>
        <div class="max-h-[320px] overflow-y-auto p-1">
            @php 
                $notifications = [
                    ['icon' => 'solar:user-plus-bold-duotone', 'color' => 'text-brand', 'title' => 'Pengguna baru terdaftar', 'time' => '2 menit yang lalu'],
                    ['icon' => 'solar:cart-check-bold-duotone', 'color' => 'text-success', 'title' => 'Pesanan #1042 selesai', 'time' => '18 menit yang lalu'],
                    ['icon' => 'solar:danger-triangle-bold-duotone', 'color' => 'text-danger', 'title' => 'Pembayaran #893 gagal', 'time' => '3 jam yang lalu'],
                ];
            @endphp
            @foreach($notifications as $notif)
                <a class="flex items-start gap-3 p-3 rounded-2xl hover:bg-bg transition-colors cursor-pointer group">
                    <div class="w-8 h-8 rounded-full bg-bg flex items-center justify-center shrink-0">
                        <iconify-icon icon="{{ $notif['icon'] }}" width="18" height="18" class="{{ $notif['color'] }}"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-text mb-0.5 group-hover:text-brand">{{ $notif['title'] }}</p>
                        <p class="text-[11px] text-muted-light">{{ $notif['time'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="p-1 border-t border-border mt-1">
            <button class="btn btn-secondary w-full justify-center bg-transparent border-0 font-bold hover:text-brand">Lihat Semua</button>
        </div>
      </div>
    </div>

    <div class="w-px h-5.5 bg-border mx-1"></div>

    <!-- User Profile -->
    <div x-data="{ open: false }" class="relative">
      <div @click="open = !open" class="flex items-center gap-2 p-1 md:pr-2.5 rounded-xl cursor-pointer transition-all hover:bg-bg">
        <div class="w-[32px] h-[32px] bg-brand-light text-brand text-[11px] font-bold flex items-center justify-center rounded-full overflow-hidden border border-brand-light">
          @if(auth()->user()->foto_profile)
            <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Profile" class="w-full h-full object-cover">
          @else
            {{ substr(auth()->user()->name, 0, 1) }}{{ substr(strrchr(auth()->user()->name, ' '), 1, 1) ?: '' }}
          @endif
        </div>
        <span class="text-[13px] font-bold text-text hidden md:block tracking-tight">{{ explode(' ', auth()->user()->name)[0] }}</span>
        <iconify-icon icon="solar:alt-arrow-down-linear" width="14" height="14" :class="open && 'rotate-180'" class="transition-transform duration-200 text-muted-light"></iconify-icon>
      </div>
      <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute right-0 top-[calc(100%+8px)] bg-surface rounded-[24px] shadow-lg border border-border p-1.5 z-55 w-[220px]" x-cloak>
        <div class="p-3 mb-1.5 bg-bg rounded-2xl">
            <p class="text-[13px] font-extrabold text-text truncate">{{ auth()->user()->name }}</p>
            <p class="text-[11px] text-muted-light truncate capitalize">{{ auth()->user()->role }}</p>
        </div>
        <a class="flex items-center gap-2.5 p-3 rounded-2xl text-[13px] font-semibold text-text hover:bg-bg transition-colors" href="{{ url('settings') }}">
          <iconify-icon icon="solar:user-id-linear" width="18" height="18" class="text-brand"></iconify-icon>
          Profil Saya
        </a>
        <a class="flex items-center gap-2.5 p-3 rounded-2xl text-[13px] font-semibold text-text hover:bg-bg transition-colors" href="{{ url('settings') }}">
          <iconify-icon icon="solar:shield-keyhole-linear" width="18" height="18" class="text-muted-light"></iconify-icon>
          Keamanan
        </a>
        <div class="h-px bg-border my-1 mx-2"></div>
        <button @click.prevent="$dispatch('open-alert-logout')" class="flex items-center gap-2.5 p-3 rounded-2xl text-[13px] font-bold text-red-500 hover:bg-red-50 transition-colors w-full">
          <iconify-icon icon="solar:logout-2-linear" width="18" height="18"></iconify-icon>
          Keluar
        </button>
      </div>
    </div>
  </div>
</div>
