<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') Auth NexaDash</title>

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
  <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
  @vite('resources/css/app.css')
  @stack('styles')
</head>

<body :data-theme="darkMode ? 'dark' : 'light'" x-data="{ 
          darkMode: localStorage.getItem('theme-dark') === 'true' 
      }" x-init="$watch('darkMode', val => localStorage.setItem('theme-dark', val))"
  class="bg-bg text-text min-h-screen antialiased">
  <div class="min-h-screen flex items-center justify-center bg-bg p-[30px] max-[480px]:p-0 max-[480px]:bg-surface"
    x-data="{ loading: false, showPass: false, showPass2: false }">
    <div
      class="w-full max-w-[440px] bg-surface rounded-[24px] shadow-lg p-[50px_40px] flex flex-col relative animate-fade-in max-[480px]:max-w-full max-[480px]:h-screen max-[480px]:rounded-none max-[480px]:shadow-none max-[480px]:p-[40px_24px] max-[480px]:justify-center">

      <div class="absolute top-6 right-8">
        <button @click="darkMode = !darkMode"
          class="btn btn-icon btn-secondary !w-9 !h-9 border-0 shadow-none bg-transparent hover:bg-bg/50">
          <iconify-icon x-show="!darkMode" icon="solar:moon-bold" width="20" height="20"
            class="text-muted"></iconify-icon>
          <iconify-icon x-show="darkMode" icon="solar:sun-bold" width="20" height="20"
            class="text-amber-400"></iconify-icon>
        </button>
      </div>

      <div class="flex items-center justify-center gap-3 mb-10">
        <div class="w-10 h-10 bg-bg rounded-xl flex items-center justify-center text-brand">
          <iconify-icon icon="solar:box-minimalistic-bold-duotone" width="24" height="24"></iconify-icon>
        </div>
        <span class="text-[24px] font-extrabold text-text tracking-[-0.03em]">NexaDash</span>
      </div>

      <div class="w-full">
        @yield('content')
      </div>

      <div class="mt-10 text-center text-[11px] text-muted-light tracking-[0.02em]">
        &copy; 2025 NEXADASH SYSTEM. ALL RIGHTS RESERVED.
      </div>

    </div>
  </div>

  @stack('scripts')
</body>

</html>