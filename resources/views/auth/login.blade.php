@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
  <div class="mb-8 text-center">
    <h1 class="text-2xl font-bold text-text tracking-tight mb-2">Welcome Back</h1>
    <p class="text-[14px] text-muted-light leading-relaxed">Please enter your credentials to continue.</p>
  </div>

  <form method="POST" action="{{ url('login') }}" @submit="loading = true">
    @csrf
    <div class="flex flex-col gap-4 mb-5">
      <div>
        <label class="text-[12px] font-semibold text-muted block mb-1.5">Alamat Email</label>
        <div class="relative">
          <iconify-icon icon="solar:letter-linear" width="18" height="18" class="i-left text-muted-light"></iconify-icon>
          <input type="email" name="email"
            class="form-input pl-10! bg-bg border-border text-text @error('email') border-danger @enderror"
            placeholder="john@example.com" value="{{ old('email', 'admin@nexadash.io') }}" required autofocus />
        </div>
        @error('email')
          <p class="text-[11px] text-danger mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label class="text-[12px] font-semibold text-muted block mb-1.5">Kata Sandi</label>
        <div class="relative">
          <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
            class="i-left text-muted-light"></iconify-icon>
          <input :type="showPass ? 'text' : 'password'" name="password"
            class="form-input pl-10! pr-10! bg-bg border-border text-text" placeholder="••••••••" value="admin123"
            required />
          <iconify-icon @click="showPass = !showPass" class="i-right text-muted-light cursor-pointer"
            :icon="showPass ? 'solar:eye-linear' : 'solar:eye-closed-linear'" width="18" height="18"></iconify-icon>
        </div>
      </div>
    </div>

    <div class="flex items-center justify-between mb-6">
      <label class="flex items-center gap-2 cursor-pointer text-[13px] text-muted">
        <input type="checkbox" name="remember" class="accent-brand w-4 h-4 rounded" {{ old('remember') ? 'checked' : '' }} />
        Keep me signed in
      </label>
      <a href="{{ route('password.request') }}"
        class="text-[13px] text-brand font-medium no-underline transition-opacity duration-200 hover:opacity-80">Forgot?</a>
    </div>

    <button type="submit"
      class="btn btn-primary w-full h-12 justify-center rounded-xl font-semibold shadow-md transition-all duration-200"
      :class="loading && 'opacity-70 cursor-not-allowed'" :disabled="loading">
      <template x-if="!loading">
        <span class="flex items-center gap-2">
          Continue
          <iconify-icon icon="solar:arrow-right-linear" width="18" height="18"></iconify-icon>
        </span>
      </template>
      <template x-if="loading">
        <iconify-icon icon="line-md:loading-twotone-loop" width="20" height="20"></iconify-icon>
      </template>
    </button>
  </form>

  <p class="text-center text-[14px] text-muted mt-7">
    Don't have an account?
    <a href="{{ url('register') }}" class="text-brand font-semibold no-underline ml-1">Create one</a>
  </p>
@endsection