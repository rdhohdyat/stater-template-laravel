<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dasbor — NexaDash')</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    @vite('resources/css/app.css')
    @stack('styles')
</head>

<body :data-theme="darkMode ? 'dark' : 'light'" x-data="{ 
          darkMode: localStorage.getItem('theme-dark') === 'true' 
      }" x-init="$watch('darkMode', val => localStorage.setItem('theme-dark', val))"
    class="bg-bg text-text selection:bg-brand selection:text-white antialiased">

    <div class="flex min-h-screen" x-data="{ 
        collapsed: localStorage.getItem('sidebar-collapsed') === 'true', 
        mobileOpen: false
     }" x-init="$watch('collapsed', value => localStorage.setItem('sidebar-collapsed', value))"
        @keydown.escape.window="mobileOpen = false">

        @include('partials.sidebar')

        <div class="flex-1 transition-[padding] duration-300 min-w-0"
            :class="[collapsed ? 'md:pl-[88px]' : 'md:pl-[246px]', 'pl-0']">

            <div class="md:p-[16px_20px_30px] p-[15px_15px_30px]">
                @include('partials.topbar')

                <main class="animate-fade-in">
                    @if(session('error'))
                        <x-alert type="error" title="Akses Ditolak" class="mb-5">
                            {{ session('error') }}
                        </x-alert>
                    @endif

                    @if(session('success'))
                        <x-toast type="success"
                            x-init="$nextTick(() => { $dispatch('notify', { message: '{{ session('success') }}', type: 'success' }) })" />
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <x-modal-alert id="logout" type="error" title="Keluar dari Sesi?">
        <p class="text-[14px] text-muted leading-relaxed">Anda akan keluar dari akun
            <strong>{{ auth()->user()->name }}</strong>. Anda perlu memasukkan kembali email
            dan kata sandi untuk mengakses dasbor.
        </p>

        <x-slot name="actions">
            <div class="grid grid-cols-2 gap-2.5 w-full mt-4">
                <button @click="$dispatch('close-alert-logout')" class="btn btn-secondary justify-center">
                    Batal
                </button>

                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-danger justify-center">
                    Ya, Keluar
                </button>
            </div>
        </x-slot>
    </x-modal-alert>

    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
        @csrf
    </form>

    @stack('scripts')
</body>

</html>