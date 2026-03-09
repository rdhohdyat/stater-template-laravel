<!-- Modal Create -->
<template x-teleport="body">
    <template x-if="modalCreate">
        <div class="modal-overlay" @click.self="modalCreate = false" x-cloak
            x-init="document.body.style.overflow = 'hidden'; return () => document.body.style.overflow = ''"
            @unload.window="document.body.style.overflow = ''">
            <div class="modal-box animate-fade-up">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="flex items-start justify-between mb-5.5">
                        <div>
                            <h3 class="text-[17px] font-extrabold tracking-tight">Tambah Pengguna Baru</h3>
                            <p class="text-[13px] text-muted mt-0.75">Isi detail untuk membuat pengguna.</p>
                        </div>
                        <button type="button" @click="modalCreate = false" class="btn btn-icon btn-secondary -mt-1">
                            <iconify-icon icon="lucide:x" width="20" height="20"
                                class="text-muted-light"></iconify-icon>
                        </button>
                    </div>
                    <div class="flex flex-col gap-3.5">
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Nama Lengkap</label>
                            <div class="relative">
                                <iconify-icon icon="solar:user-rounded-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="text" name="name" class="form-input pl-10!" required
                                    placeholder="John Doe" />
                            </div>
                        </div>
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Email</label>
                            <div class="relative">
                                <iconify-icon icon="solar:letter-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="email" name="email" class="form-input pl-10!" required
                                    placeholder="john@example.com" />
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <label class="text-[12px] font-semibold text-muted block mb-1.5">Peran</label>
                                <div class="relative">
                                    <iconify-icon icon="solar:shield-star-linear" width="18" height="18"
                                        class="i-left text-muted-light"></iconify-icon>
                                    <select name="role" class="form-input pl-10!" required>
                                        <option value="">Pilih peran…</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="text-[12px] font-semibold text-muted block mb-1.5">Status</label>
                                <div class="relative">
                                    <iconify-icon icon="solar:info-circle-linear" width="18" height="18"
                                        class="i-left text-muted-light"></iconify-icon>
                                    <select name="status" class="form-input pl-10!" required>
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Kata Sandi</label>
                            <div class="relative">
                                <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="password" name="password" class="form-input pl-10!" required
                                    placeholder="********" />
                            </div>
                        </div>
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Bio</label>
                            <textarea name="bio" class="form-input min-h-[80px] resize-y"
                                placeholder="Tulis bio singkat..."></textarea>
                        </div>
                    </div>
                    <div class="flex gap-2.5 mt-5.5 pt-4.5 border-t border-border">
                        <button type="button" @click="modalCreate = false"
                            class="btn btn-secondary flex-1 justify-center">Batal</button>
                        <button type="submit" class="btn btn-primary flex-1 justify-center">
                            <iconify-icon icon="solar:user-plus-linear" width="18" height="18"></iconify-icon>
                            Buat Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</template>

<!-- Modal Edit -->
<template x-teleport="body">
    <template x-if="modalEdit">
        <div class="modal-overlay" @click.self="modalEdit = false" x-cloak
            x-init="document.body.style.overflow = 'hidden'; return () => document.body.style.overflow = ''"
            @unload.window="document.body.style.overflow = ''">
            <div class="modal-box animate-fade-up">
                <form :action="`/users/${currentUser.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex items-start justify-between mb-5.5">
                        <div>
                            <h3 class="text-[17px] font-extrabold tracking-tight">Edit Pengguna</h3>
                            <p class="text-[13px] text-muted mt-0.75">Perbarui detail pengguna <span
                                    x-text="currentUser.name"></span>.</p>
                        </div>
                        <button type="button" @click="modalEdit = false" class="btn btn-icon btn-secondary -mt-1">
                            <iconify-icon icon="lucide:x" width="20" height="20"
                                class="text-muted-light"></iconify-icon>
                        </button>
                    </div>
                    <div class="flex flex-col gap-3.5">
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Nama Lengkap</label>
                            <div class="relative">
                                <iconify-icon icon="solar:user-rounded-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="text" name="name" x-model="currentUser.name" class="form-input pl-10!"
                                    required />
                            </div>
                        </div>
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Email</label>
                            <div class="relative">
                                <iconify-icon icon="solar:letter-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="email" name="email" x-model="currentUser.email" class="form-input pl-10!"
                                    required />
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <label class="text-[12px] font-semibold text-muted block mb-1.5">Peran</label>
                                <div class="relative">
                                    <iconify-icon icon="solar:shield-star-linear" width="18" height="18"
                                        class="i-left text-muted-light"></iconify-icon>
                                    <select name="role" class="form-input pl-10!" required>
                                        <option value="">Pilih peran…</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="text-[12px] font-semibold text-muted block mb-1.5">Status</label>
                                <div class="relative">
                                    <iconify-icon icon="solar:info-circle-linear" width="18" height="18"
                                        class="i-left text-muted-light"></iconify-icon>
                                    <select name="status" x-model="currentUser.status" class="form-input pl-10!"
                                        required>
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Kata Sandi (Kosongkan jika
                                tidak ingin diubah)</label>
                            <div class="relative">
                                <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <input type="password" name="password" class="form-input pl-10!"
                                    placeholder="********" />
                            </div>
                        </div>
                        <div>
                            <label class="text-[12px] font-semibold text-muted block mb-1.5">Bio</label>
                            <textarea name="bio" x-model="currentUser.bio"
                                class="form-input min-h-[80px] resize-y"></textarea>
                        </div>
                    </div>
                    <div class="flex gap-2.5 mt-5.5 pt-4.5 border-t border-border">
                        <button type="button" @click="modalEdit = false"
                            class="btn btn-secondary flex-1 justify-center">Batal</button>
                        <button type="submit" class="btn btn-primary flex-1 justify-center">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</template>

<!-- Modal Delete -->
<template x-teleport="body">
    <template x-if="modalDelete">
        <div class="modal-overlay" @click.self="modalDelete = false" x-cloak
            x-init="document.body.style.overflow = 'hidden'; return () => document.body.style.overflow = ''"
            @unload.window="document.body.style.overflow = ''">
            <div class="modal-box animate-fade-up max-w-[400px] text-center">
                <div
                    class="w-[60px] h-[60px] bg-[#fee2e2] text-[#ef4444] rounded-full flex items-center justify-center mx-auto mb-5">
                    <iconify-icon icon="solar:danger-triangle-bold-duotone" width="30" height="30"></iconify-icon>
                </div>
                <h3 class="text-[18px] font-extrabold mb-2">Hapus Pengguna?</h3>
                <p class="text-[14px] text-muted leading-relaxed mb-5">Apakah Anda yakin ingin menghapus <span
                        x-text="currentUser.name" class="font-bold text-text"></span>? Tindakan ini tidak dapat
                    dibatalkan.
                </p>
                <form :action="`/users/${currentUser.id}`" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="text-left mb-5">
                        <label class="text-[13px] font-semibold text-muted block mb-1.5">Konfirmasi Kata Sandi
                            Anda</label>
                        <div class="relative">
                            <iconify-icon icon="solar:lock-password-linear" width="18" height="18"
                                class="i-left text-muted-light"></iconify-icon>
                            <input type="password" name="password" class="form-input pl-10!" required
                                placeholder="Masukkan kata sandi Anda..." />
                        </div>
                    </div>

                    <div class="flex gap-2.5">
                        <button type="button" @click="modalDelete = false"
                            class="btn btn-secondary flex-1 justify-center">Batal</button>
                        <button type="submit" class="btn btn-danger flex-1 justify-center">Hapus Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</template>

<!-- Modal Export -->
<template x-teleport="body">
    <template x-if="modalExport">
        <div class="modal-overlay" @click.self="modalExport = false" x-cloak
            x-init="document.body.style.overflow = 'hidden'; return () => document.body.style.overflow = ''"
            @unload.window="document.body.style.overflow = ''">
            <div class="modal-box animate-fade-up max-w-[460px]">
                <form action="{{ route('users.export.excel') }}" method="GET">
                    <div class="flex items-start justify-between mb-5.5">
                        <div>
                            <h3 class="text-[17px] font-extrabold tracking-tight">Export Data Pengguna</h3>
                            <p class="text-[13px] text-muted mt-0.75">Atur filter untuk data yang ingin di-export.</p>
                        </div>
                        <button type="button" @click="modalExport = false" class="btn btn-icon btn-secondary -mt-1">
                            <iconify-icon icon="lucide:x" width="20" height="20"
                                class="text-muted-light"></iconify-icon>
                        </button>
                    </div>

                    <div class="flex flex-col gap-4.5">
                        <!-- Export Type -->
                        <div>
                            <label class="text-[12px] font-bold text-muted block mb-2 uppercase tracking-wider">Cakupan
                                Data</label>
                            <div class="relative">
                                <iconify-icon icon="solar:document-linear" width="18" height="18"
                                    class="i-left text-muted-light"></iconify-icon>
                                <select name="export_type" x-model="exportType" class="form-input pl-10!">
                                    <option value="all">Semua Data</option>
                                    <option value="date_range">Rentang Tanggal Bergabung</option>
                                </select>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <template x-if="exportType === 'date_range'">
                            <div class="grid grid-cols-2 gap-3" x-transition>
                                <div>
                                    <label class="text-[12px] font-semibold text-muted block mb-1.5">Tanggal
                                        Mulai</label>
                                    <input type="date" name="start_date" class="form-input" required />
                                </div>
                                <div>
                                    <label class="text-[12px] font-semibold text-muted block mb-1.5">Tanggal
                                        Akhir</label>
                                    <input type="date" name="end_date" class="form-input" required />
                                </div>
                            </div>
                        </template>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Filter Role -->
                            <div>
                                <label
                                    class="text-[12px] font-bold text-muted block mb-2 uppercase tracking-wider">Peran</label>
                                <div class="relative">
                                    <iconify-icon icon="solar:shield-star-linear" width="18" height="18"
                                        class="i-left text-muted-light"></iconify-icon>
                                    <select name="role" class="form-input pl-10!">
                                        <option value="Semua Peran">Semua Peran</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Status -->
                            <div>
                                <label
                                    class="text-[12px] font-bold text-muted block mb-2 uppercase tracking-wider">Status</label>
                                <div class="relative">
                                    <iconify-icon icon="solar:info-circle-linear" width="18" height="18"
                                        class="i-left text-muted-light"></iconify-icon>
                                    <select name="status" class="form-input pl-10!">
                                        <option value="Semua Status">Semua Status</option>
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2.5 mt-7 pt-5 border-t border-border">
                        <button type="button" @click="modalExport = false"
                            class="btn btn-secondary flex-1 justify-center">Batal</button>
                        <button type="submit" @click="setTimeout(() => modalExport = false, 500)"
                            class="btn btn-primary flex-1 justify-center">
                            <iconify-icon icon="solar:download-square-linear" width="18" height="18"></iconify-icon>
                            Download Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</template>