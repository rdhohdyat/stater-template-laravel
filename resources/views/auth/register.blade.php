@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
  <div x-data="{
                    password: '',
                    get strength() {
                      let s = 0;
                      if (this.password.length >= 8) s++;
                      if (/[A-Z]/.test(this.password)) s++;
                      if (/[0-9]/.test(this.password)) s++;
                      if (/[^A-Za-z0-9]/.test(this.password)) s++;
                      return s;
                    },
                    get strengthLabel() { return ['','Lemah','Cukup','Baik','Kuat'][this.strength]; },
                    get strengthColor() { return ['','#ef4444','#f97316','#eab308','#22c55e'][this.strength]; }
                  }" class="animate-fade-up">
    <div class="mb-8 text-center">
      <h1 class="text-2xl font-bold text-text tracking-tight mb-2">Create Account</h1>
      <p class="text-[14.5px] text-muted-light leading-relaxed">Join us and start managing your dashboard today.</p>
    </div>

    <form method="POST" action="{{ url('register') }}" @submit="loading = true">
      @csrf
      <div class="flex flex-col gap-4 mb-5">
        <div>
          <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">Nama Lengkap</label>
          <div class="relative">
            <iconify-icon icon="solar:user-rounded-linear" width="18" height="18"
              class="i-left text-muted-light"></iconify-icon>
            <input type="text" name="name"
              class="form-input pl-10! bg-bg border-border text-text @error('name') border-danger! @enderror"
              placeholder="John Doe" value="{{ old('name') }}" required />
          </div>
          @error('name')
            <p class="text-[11px] text-danger mt-1.5 ml-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">Alamat Email</label>
          <div class="relative">
            <iconify-icon icon="solar:letter-linear" width="18" height="18"
              class="i-left text-muted-light"></iconify-icon>
            <input type="email" name="email"
              class="form-input pl-10! bg-bg border-border text-text @error('email') border-danger! @enderror"
              placeholder="john@example.com" value="{{ old('email') }}" required />
          </div>
          @error('email')
            <p class="text-[11px] text-danger mt-1.5 ml-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">Kata Sandi</label>
          <div class="relative">
            <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
              class="i-left text-muted-light"></iconify-icon>
            <input :type="showPass ? 'text' : 'password'" x-model="password" name="password"
              class="form-input px-10! bg-bg border-border text-text @error('password') border-danger! @enderror"
              placeholder="Min. 8 karakter" required />
            <iconify-icon @click="showPass=!showPass" class="i-right text-muted-light cursor-pointer"
              :icon="showPass ? 'solar:eye-linear' : 'solar:eye-closed-linear'" width="18" height="18"></iconify-icon>
          </div>
          @error('password')
            <p class="text-[11px] text-danger mt-1.5 ml-1">{{ $message }}</p>
          @enderror
          <!-- Strength Indicator -->
          <div x-show="password.length > 0" class="mt-2.5 px-1">
            <div class="flex gap-1 mb-1.5">
              <template x-for="i in 4">
                <div class="h-1 flex-1 rounded-full transition-all duration-300"
                  :style="{ background: i <= strength ? strengthColor : 'var(--color-border)' }"></div>
              </template>
            </div>
            <p class="text-[11px] font-bold" :style="{ color: strengthColor }" x-text="'Kata sandi ' + strengthLabel"></p>
          </div>
        </div>

        <div>
          <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">Konfirmasi Kata Sandi</label>
          <div class="relative">
            <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
              class="i-left text-muted-light"></iconify-icon>
            <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation"
              class="form-input px-10! bg-bg border-border text-text" placeholder="Ulangi kata sandi" required />
            <iconify-icon @click="showPass2=!showPass2" class="i-right text-muted-light cursor-pointer"
              :icon="showPass2 ? 'solar:eye-linear' : 'solar:eye-closed-linear'" width="18" height="18"></iconify-icon>
          </div>
        </div>
      </div>

      <label class="flex items-start gap-2.5 cursor-pointer text-[13.5px] text-muted mb-6 leading-relaxed">
        <input type="checkbox" class="accent-brand w-4 h-4 mt-0.5 rounded-lg shrink-0" required />
        <span>I agree to the <a href="#" class="text-brand font-bold hover:underline">Terms</a> and <a href="#"
            class="text-brand font-bold hover:underline">Privacy Policy</a>.</span>
      </label>

      <button type="submit"
        class="btn btn-primary w-full h-12 justify-center text-[15px] font-bold shadow-lg shadow-brand/20 transition-all hover:translate-y-[-1px]"
        :class="loading && 'opacity-70 cursor-not-allowed'" :disabled="loading">
        <template x-if="!loading">
          <span class="flex items-center gap-2">
            Create Account
            <iconify-icon icon="solar:arrow-right-linear" width="18" height="18"></iconify-icon>
          </span>
        </template>
        <template x-if="loading">
          <iconify-icon icon="line-md:loading-twotone-loop" width="22" height="22"></iconify-icon>
        </template>
      </button>
    </form>

    <p class="text-center text-[14px] text-muted mt-8">
      Already have an account?
      <a href="{{ url('login') }}" class="text-brand font-bold hover:underline ml-1">Sign in</a>
    </p>
  </div>
@endsection