@extends('layouts.app')

@section('page_title', 'Pengaturan')

@section('content')
    <div class="animate-fade-up mb-6">
        <h1 class="text-[22px] font-extrabold tracking-tight">Pengaturan</h1>
        <p class="text-muted text-[14px] mt-1">Kelola akun dan preferensi Anda.</p>
    </div>

     @if(session('success'))
        <div
            class="mb-5 p-[12px_16px] bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-[14px] flex items-center gap-2.5">
            <iconify-icon icon="solar:check-circle-bold-duotone" width="20" height="20" class="text-emerald-500"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div
            class="mb-5 p-[12px_16px] bg-rose-50 border border-rose-100 rounded-xl text-rose-700 text-[14px] flex items-center gap-2.5">
            <iconify-icon icon="solar:danger-circle-bold-duotone" width="20" height="20" class="text-rose-500"></iconify-icon>
            {{ session('error') }}
        </div>
    @endif

    <div class="animate-fade-up grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Kolom Kiri: Form -->
        <div class="card p-[22px]">
            <div class="text-[15px] font-bold mb-1">Informasi Profil</div>
            <p class="text-[13px] text-muted mb-5">Perbarui detail pribadi Anda.</p>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-3.5">
                    <div>
                        <label class="text-[12px] font-semibold text-muted block mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <iconify-icon icon="solar:user-rounded-linear" width="18" height="18"
                                class="i-left text-muted-light"></iconify-icon>
                            <input type="text" name="name" class="form-input pl-10! bg-bg"
                                value="{{ old('name', $user->name) }}" required />
                        </div>
                        @error('name')<p class="text-[#dc2626] text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-muted block mb-1.5">Email</label>
                        <div class="relative">
                            <iconify-icon icon="solar:letter-linear" width="18" height="18"
                                class="i-left text-muted-light"></iconify-icon>
                            <input type="email" name="email" class="form-input pl-10! bg-bg"
                                value="{{ old('email', $user->email) }}" required />
                        </div>
                        @error('email')<p class="text-[#dc2626] text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-muted block mb-1.5">Peran</label>
                        <div class="relative">
                            <iconify-icon icon="solar:shield-star-linear" width="18" height="18"
                                class="i-left text-muted-light"></iconify-icon>
                            <input type="text" class="form-input pl-10! bg-bg opacity-70 cursor-not-allowed"
                                value="{{ ucfirst($user->role) }}" readonly />
                        </div>
                        <p class="text-[11px] text-muted-light mt-1">Peran Anda tidak dapat diubah
                            sendiri.</p>
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-muted block mb-1.5">Bio</label>
                        <textarea name="bio"
                            class="form-input bg-bg rows-3 resize-none">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')<p class="text-[#dc2626] text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mt-[18px] pt-4 border-t border-border flex gap-2.5">
                    <button type="submit" class="btn btn-primary">
                        <iconify-icon icon="solar:diskette-linear" width="18" height="18"></iconify-icon>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('settings') }}" class="btn btn-secondary no-underline">Batal</a>
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Avatar & Zona Berbahaya -->
        <div class="flex flex-col gap-4">

            <!-- Avatar Card Khusus -->
            <div class="card p-[22px]">
                <div class="text-[15px] font-bold mb-1">Foto Profil</div>
                <p class="text-[13px] text-muted mb-4">Pilih foto terbaik Anda.</p>

                <div class="flex flex-col items-center text-center p-6 bg-bg rounded-xl border border-dashed border-border">
                    <div
                        class="w-[90px] h-[90px] bg-brand-light text-brand text-[28px] font-[800] overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] mb-5 flex items-center justify-center rounded-full">
                        @if($user->foto_profile)
                            <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Profile"
                                class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strrchr($user->name, ' '), 1, 1)) ?: '' }}
                        @endif
                    </div>
                    <div class="w-full">
                        <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data"
                            id="photoForm">
                            @csrf
                            <input type="file" name="foto_profile" id="foto_profile" class="hidden"
                                onchange="document.getElementById('photoForm').submit();">
                            <button type="button" class="btn btn-secondary w-full justify-center rounded-xl mb-2 bg-white"
                                onclick="document.getElementById('foto_profile').click();">
                                <iconify-icon icon="solar:upload-minimalistic-linear" width="16" height="16"></iconify-icon>
                                Unggah Foto Baru
                            </button>
                        </form>
                        <p class="text-[11.5px] text-muted leading-relaxed">Format didukung: JPG, PNG,
                            GIF.<br>Ukuran maksimal file adalah 2MB.</p>
                    </div>
                </div>
            </div>

            <!-- Security Card -->
            <div class="card p-[22px]" x-data="{ 
                    password: '',
                    get strength() {
                        if (!this.password) return 0;
                        let s = 0;
                        if (this.password.length > 7) s++;
                        if (/[A-Z]/.test(this.password)) s++;
                        if (/[0-9]/.test(this.password)) s++;
                        if (/[^A-Za-z0-9]/.test(this.password)) s++;
                        return s;
                    },
                    get strengthText() {
                        return ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'][this.strength];
                    },
                    get strengthColor() {
                        return ['bg-border', 'bg-rose-500', 'bg-amber-500', 'bg-emerald-500', 'bg-brand'][this.strength];
                    }
                }">
                <div class="text-[15px] font-bold mb-1">Keamanan Akun</div>
                <p class="text-[13px] text-muted mb-5">Perbarui kata sandi Anda secara berkala.</p>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="password" name="current_password" class="form-input pl-10! bg-bg" required />
                            </div>
                            @error('current_password')<p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Kata Sandi Baru</label>
                            <div class="relative mb-2">
                                <iconify-icon icon="solar:key-minimalistic-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="password" name="password" x-model="password" class="form-input pl-10! bg-bg"
                                    required />
                            </div>

                            <!-- Password Strength Meter -->
                            <div class="flex items-center gap-2 px-1">
                                <div class="flex-1 h-1 bg-border/40 rounded-full overflow-hidden flex gap-1">
                                    <template x-for="i in 1,2,3,4">
                                        <div class="flex-1 h-full transition-all duration-500"
                                            :class="i <= strength ? strengthColor : 'bg-transparent'"></div>
                                    </template>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider min-w-[70px] text-right"
                                    :class="strength > 0 ? 'text-text' : 'text-muted-light'" x-text="strengthText"></span>
                            </div>
                            @error('password')<p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Konfirmasi Password
                                Baru</label>
                            <div class="relative">
                                <iconify-icon icon="solar:check-read-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="password" name="password_confirmation" class="form-input pl-10! bg-bg"
                                    required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full justify-center mt-6 py-2.5">
                        <iconify-icon icon="solar:shield-keyhole-bold-duotone" width="20" height="20"></iconify-icon>
                        Perbarui Password
                    </button>
                </form>
            </div>

            <!-- Zona Berbahaya -->
            <div class="card p-[22px] border-dashed border-[#fecaca] bg-transparent" x-data="{ showDeleteForm: false }">
                <div class="flex items-center gap-2 mb-1">
                    <iconify-icon icon="solar:shield-warning-bold-duotone" width="22" height="22"
                        class="text-[#dc2626]"></iconify-icon>
                    <div class="text-[15px] font-extrabold text-[#dc2626]">Zona Berbahaya</div>
                </div>
                <p class="text-[13px] text-[#991b1b] mb-[18px] opacity-80">Tindakan yang tidak dapat
                    dibatalkan, harap berhati-hati.</p>

                <div class="flex items-center justify-between p-4 bg-red-500/5 rounded-xl border border-dashed border-red-500/30 flex-wrap gap-2.5"
                    x-show="!showDeleteForm" x-collapse>
                    <div>
                        <div class="text-[13.5px] font-bold text-[#dc2626]">Hapus Akun Permanen</div>
                        <div class="text-[12px] text-[#ef4444] mt-0.5">Semua data akan dihapus selamanya.</div>
                    </div>
                    <button @click="showDeleteForm = true" class="btn btn-danger py-1.5 px-3.5 font-bold tracking-wide">
                        Hapus Akun
                    </button>
                </div>

                <!-- Delete Confirmation Form -->
                <div x-show="showDeleteForm" x-cloak x-collapse
                    class="mt-4 p-5 bg-red-50 rounded-2xl border border-red-100">
                    <form action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4">
                            <label class="text-[12px] font-bold text-red-900 block mb-1.5">Konfirmasi Password</label>
                            <input type="password" name="password" placeholder="Masukkan password Anda"
                                class="form-input border-red-200 focus:border-red-500 focus:ring-red-500/10 bg-white"
                                required>
                            @error('password', 'userDeletion')
                                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="text-[12px] font-bold text-red-900 block mb-1.5">
                                Ketik <span class="bg-red-200 px-1.5 py-0.5 rounded text-red-800">KONFIRMASI</span> untuk
                                melanjutkan
                            </label>
                            <input type="text" name="confirmation" placeholder="Tulis KONFIRMASI di sini"
                                class="form-input border-red-200 focus:border-red-500 focus:ring-red-500/10 bg-white"
                                required>
                        </div>

                        <div class="flex gap-2.5">
                            <button type="submit" class="btn btn-danger flex-1 justify-center py-2.5">
                                <iconify-icon icon="solar:trash-bin-2-bold" width="18" height="18"></iconify-icon>
                                Ya, Hapus Akun Saya
                            </button>
                            <button type="button" @click="showDeleteForm = false" class="btn btn-secondary px-5">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection