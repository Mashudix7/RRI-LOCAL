<div class="min-h-[80vh] flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-slate-700">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="inline-flex w-16 h-16 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Konfigurasi Keamanan</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Atur kata sandi untuk melindungi halaman ini.</p>
            </div>
            
            <?php if($this->session->flashdata('error')): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/server_credentials/setup_lock') ?>" method="POST" class="space-y-6">
                <!-- Recovery Code Display -->
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50 rounded-lg p-4">
                    <label class="block text-xs font-semibold text-amber-800 dark:text-amber-400 uppercase tracking-wider mb-2">
                        Kode Pemulihan (Simpan Ini!)
                    </label>
                    <div class="flex items-center gap-2">
                        <code class="flex-1 bg-white dark:bg-slate-900 px-3 py-2 rounded border border-amber-200 dark:border-amber-700 font-mono text-lg font-bold text-amber-600 dark:text-amber-400 text-center tracking-widest select-all">
                            <?= $recovery_code ?>
                        </code>
                    </div>
                    <p class="text-xs text-amber-700 dark:text-amber-500 mt-2">
                        Gunakan kode ini jika Anda lupa kata sandi. Masukkan kode ini di kolom password untuk mereset.
                    </p>
                    <input type="hidden" name="recovery_code" value="<?= $recovery_code ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi Halaman</label>
                    <input type="password" name="password" required class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Buat kata sandi baru">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="confirm_password" required class="w-full rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Ulangi kata sandi">
                </div>

                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Simpan & Kunci Halaman
                </button>
            </form>
        </div>
    </div>
</div>
