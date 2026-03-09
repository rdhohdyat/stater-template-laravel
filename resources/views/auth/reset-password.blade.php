@extends('layouts.auth')

@section('title', 'Buat Kata Sandi Baru')

@section('content')
    <div class="mb-8 text-center animate-fade-up">
        <h1 class="text-2xl font-bold text-text tracking-tight mb-2">New Password</h1>
        <p class="text-[14.5px] text-muted-light leading-relaxed">Please set a strong password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" @submit="loading = true" class="animate-fade-up">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="flex flex-col gap-4 mb-7">
            <div>
                <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">Email Address</label>
                <div class="relative">
                    <iconify-icon icon="solar:letter-linear" width="18" height="18"
                        class="i-left text-muted-light"></iconify-icon>
                    <input type="email" name="email"
                        class="form-input pl-10! opacity-60 bg-bg border-border text-text cursor-not-allowed @error('email') border-danger! @enderror"
                        placeholder="john@example.com" value="{{ $request->email ?? old('email') }}" required readonly
                        autocomplete="email" />
                </div>
                @error('email')
                    <p class="text-[11px] text-danger mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">New Password</label>
                <div class="relative">
                    <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
                        class="i-left text-muted-light"></iconify-icon>
                    <input :type="showPass ? 'text' : 'password'" name="password"
                        class="form-input px-10! bg-bg border-border text-text @error('password') border-danger! @enderror"
                        placeholder="Min. 8 characters" required autofocus autocomplete="new-password" />
                    <iconify-icon @click="showPass = !showPass" class="i-right text-muted-light cursor-pointer"
                        :icon="showPass ? 'solar:eye-linear' : 'solar:eye-closed-linear'" width="18"
                        height="18"></iconify-icon>
                </div>
                @error('password')
                    <p class="text-[11px] text-danger mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">Confirm Password</label>
                <div class="relative">
                    <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
                        class="i-left text-muted-light"></iconify-icon>
                    <input :type="showPass ? 'text' : 'password'" name="password_confirmation"
                        class="form-input pl-10! bg-bg border-border text-text" placeholder="Repeat new password" required
                        autocomplete="new-password" />
                </div>
            </div>
        </div>

        <button type="submit"
            class="btn btn-primary w-full h-12 justify-center text-[15px] font-bold shadow-lg shadow-brand/20 transition-all hover:translate-y-[-1px]"
            :class="loading && 'opacity-70 cursor-not-allowed'" :disabled="loading">
            <template x-if="!loading">
                <span class="flex items-center gap-2">
                    Update Password
                    <iconify-icon icon="solar:check-circle-linear" width="18" height="18"></iconify-icon>
                </span>
            </template>
            <template x-if="loading">
                <iconify-icon icon="line-md:loading-twotone-loop" width="22" height="22"></iconify-icon>
            </template>
        </button>
    </form>
@endsection