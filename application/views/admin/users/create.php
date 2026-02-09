<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white"><?= $title ?></h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tambah pengguna baru</p>
        </div>
        <a href="<?= base_url('admin/users') ?>" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
        <?= form_open_multipart('admin/user_store', ['class' => 'space-y-6', 'autocomplete' => 'off']) ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" name="username" required autocomplete="off" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Password -->
                <div x-data="{ 
                    password: '', 
                    showPassword: false,
                    get strength() {
                        if (!this.password) return 0;
                        let s = 0;
                        if (this.password.length >= 8) s++;
                        if (/[A-Z]/.test(this.password)) s++;
                        if (/[a-z]/.test(this.password)) s++;
                        if (/[0-9]/.test(this.password)) s++;
                        if (/[^A-Za-z0-9]/.test(this.password)) s++;
                        return s;
                    },
                    get strengthText() {
                        const texts = ['', 'Sangat Lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
                        return texts[this.strength];
                    },
                    get strengthColor() {
                        const colors = ['bg-gray-200', 'bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-emerald-500', 'bg-green-600'];
                        return colors[this.strength];
                    },
                    get strengthPercent() {
                        return (this.strength / 5) * 100 + '%';
                    }
                }" class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" 
                               name="password" 
                               x-model="password"
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 pr-10">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                    
                    <!-- Strength Meter -->
                    <div class="space-y-1" x-show="password.length > 0">
                        <div class="flex justify-between items-center text-[10px] uppercase tracking-wider font-bold">
                            <span class="text-gray-500">Keamanan Password</span>
                            <span :class="strength < 4 ? 'text-red-500' : 'text-emerald-500'" x-text="strengthText"></span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-200 dark:bg-slate-600 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-500" 
                                 :class="strengthColor" 
                                 :style="{ width: strengthPercent }"></div>
                        </div>
                        <p class="text-[10px] text-gray-500">Minimal 8 karakter, kombinasi Huruf Besar, Angka & Simbol.</p>
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                    <select name="role" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="admin">Admin</option>
                        <option value="management">Management</option>
                        <option value="auditor">Auditor</option>
                    </select>
                </div>
                
                <!-- Avatar Upload -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <div id="preview-container" class="hidden w-20 h-20 rounded-full overflow-hidden border border-gray-200 dark:border-slate-700">
                            <img id="preview" src="#" alt="Preview" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <label class="cursor-pointer">
                            <span class="px-4 py-2 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                                Pilih File
                            </span>
                            <input type="file" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                        <span class="text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WEBP (Max 5MB)</span>
                    </div>
                </div>
            </div>

            <script>
                function previewImage(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('preview').src = e.target.result;
                            document.getElementById('preview-container').classList.remove('hidden');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

            <div class="flex justify-end pt-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Simpan Pengguna
                </button>
            </div>
        <?= form_close() ?>
    </div>
</div>
