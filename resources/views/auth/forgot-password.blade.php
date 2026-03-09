@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

@section('content')
    <div class="mb-8 text-center animate-fade-up">
        <h1 class="text-2xl font-bold text-text tracking-tight mb-2">Reset Password</h1>
        <p class="text-[14.5px] text-muted-light leading-relaxed">Enter your email to receive a secure reset link.</p>
    </div>

    @if (session('success'))
        <div
            class="mb-6 p-[12px_16px] bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-600 dark:text-emerald-400 text-[13.5px] flex items-center gap-2.5 animate-fade-in font-medium">
            <iconify-icon icon="solar:check-circle-bold-duotone" width="20" height="20"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" @submit="loading = true" class="animate-fade-up">
        @csrf
        <div class="flex flex-col gap-5 mb-7">
            <div>
                <label class="text-[12.5px] font-bold text-muted block mb-1.5 ml-1">Email Address</label>
                <div class="relative">
                    <iconify-icon icon="solar:letter-linear" width="18" height="18"
                        class="i-left text-muted-light"></iconify-icon>
                    <input type="email" name="email"
                        class="form-input pl-10! bg-bg border-border text-text @error('email') border-danger! @enderror"
                        placeholder="name@company.com" value="{{ old('email') }}" required autofocus />
                </div>
                @error('email')
                    <p class="text-[11px] text-danger mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit"
            class="btn btn-primary w-full h-12 justify-center text-[15px] font-bold shadow-lg shadow-brand/20 transition-all hover:translate-y-[-1px]"
            :class="loading && 'opacity-70 cursor-not-allowed'" :disabled="loading">
            <template x-if="!loading">
                <span class="flex items-center gap-2">
                    Send Reset Link
                    <iconify-icon icon="solar:send-square-linear" width="18" height="18"></iconify-icon>
                </span>
            </template>
            <template x-if="loading">
                <iconify-icon icon="line-md:loading-twotone-loop" width="22" height="22"></iconify-icon>
            </template>
        </button>
    </form>

    <p class="text-center text-[14px] text-muted mt-8 animate-fade-up">
        Remember your password?
        <a href="{{ url('login') }}" class="text-brand font-bold hover:underline ml-1">Back to sign in</a>
    </p>
@endsection